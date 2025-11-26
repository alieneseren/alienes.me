<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\GitHubUser;
use App\Services\GitHubService;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::ordered()->get();
        $githubUsers = GitHubUser::orderBy('username')->get();
        return view('admin.projects.index', compact('projects', 'githubUsers'));
    }

    public function create()
    {
        $githubUsers = GitHubUser::orderBy('username')->get();
        return view('admin.projects.create', compact('githubUsers'));
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->except('image', 'technologies');
        $data['technologies'] = array_map('trim', explode(',', $request->technologies));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $data['image'] = $path;
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Proje başarıyla eklendi.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->except('image', 'technologies');
        $data['technologies'] = array_map('trim', explode(',', $request->technologies));

        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            
            $path = $request->file('image')->store('projects', 'public');
            $data['image'] = $path;
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Proje başarıyla güncellendi.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Proje başarıyla silindi.');
    }

    /**
     * Get GitHub repositories
     */
    public function getGithubRepos(Request $request, GitHubService $github)
    {
        $username = $request->input('username') ?: config('services.github.username');
        
        if (!$username) {
            return response()->json([
                'success' => false,
                'message' => 'GitHub kullanıcı adı belirtilmedi.'
            ], 400);
        }

        try {
            // Fetch user profile to save/update
            $userProfile = $github->getUserProfile($username);
            if ($userProfile) {
                GitHubUser::updateOrCreate(
                    ['username' => $username],
                    [
                        'avatar_url' => $userProfile['avatar_url'] ?? null,
                        'name' => $userProfile['name'] ?? $username,
                        'bio' => $userProfile['bio'] ?? null,
                        'public_repos' => $userProfile['public_repos'] ?? 0,
                    ]
                );
            }

            $repos = $github->getRepositories($username);

            if (empty($repos)) {
                // Return demo data if GitHub API is unavailable
                return response()->json([
                    'success' => true,
                    'repos' => [
                        [
                            'id' => 1,
                            'name' => 'example-project',
                            'full_name' => $username . '/example-project',
                            'description' => 'Bu örnek bir projedir. GitHub API\'ye bağlanılamadığı için demo veri gösteriliyor.',
                            'html_url' => 'https://github.com/' . $username . '/example-project',
                            'homepage' => '',
                            'language' => 'PHP',
                            'topics' => ['laravel', 'web', 'portfolio'],
                            'stargazers_count' => 0,
                            'forks_count' => 0,
                            'created_at' => now()->toIso8601String(),
                            'updated_at' => now()->toIso8601String(),
                            'pushed_at' => now()->toIso8601String(),
                        ]
                    ],
                    'message' => 'GitHub API\'ye bağlanılamadı. Demo veri gösteriliyor.'
                ]);
            }

            return response()->json([
                'success' => true,
                'repos' => $repos,
            ]);
        } catch (\Exception $e) {
            \Log::error('GitHub repos fetch error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Import project from GitHub
     */
    public function importFromGithub(Request $request, GitHubService $github)
    {
        $request->validate([
            'repos' => 'required|array',
            'repos.*' => 'required|string',
        ]);

        $imported = [];
        $errors = [];

        foreach ($request->repos as $repoFullName) {
            $parts = explode('/', $repoFullName);
            if (count($parts) !== 2) {
                $errors[] = "$repoFullName: Geçersiz repository adı.";
                continue;
            }

            [$owner, $repo] = $parts;
            
            try {
                $repoData = $github->getRepository($owner, $repo);

                if (!$repoData) {
                    $errors[] = "$repoFullName: Repository bulunamadı.";
                    continue;
                }

                // Get description - use README if repo description is empty
                $description = $repoData['description'];
                if (empty($description)) {
                    $readme = $github->getReadme($owner, $repo);
                    if ($readme) {
                        // Extract first paragraph from README
                        $lines = explode("\n", strip_tags($readme));
                        foreach ($lines as $line) {
                            $line = trim($line);
                            if (!empty($line) && !str_starts_with($line, '#')) {
                                $description = substr($line, 0, 500);
                                break;
                            }
                        }
                    }
                }

                // Build technologies array
                $technologies = [];
                if ($repoData['language']) {
                    $technologies[] = $repoData['language'];
                }
                if (!empty($repoData['topics'])) {
                    $technologies = array_merge($technologies, $repoData['topics']);
                }

                // Create project
                Project::create([
                    'title' => $repoData['name'],
                    'description' => $description ?: 'GitHub projesinden alındı',
                    'technologies' => $technologies,
                    'github_url' => $repoData['html_url'],
                    'demo_url' => $repoData['homepage'] ?: null,
                    'is_featured' => false,
                ]);

                $imported[] = $repoData['name'];
            } catch (\Exception $e) {
                $errors[] = "$repoFullName: " . $e->getMessage();
            }
        }

        $message = count($imported) . ' proje başarıyla içe aktarıldı.';
        if (count($errors) > 0) {
            $message .= ' ' . count($errors) . ' hata oluştu.';
        }

        return response()->json([
            'success' => count($imported) > 0,
            'message' => $message,
            'imported' => $imported,
            'errors' => $errors,
        ]);
    }

    /**
     * Get GitHub users list
     */
    public function getGithubUsers()
    {
        $users = GitHubUser::orderBy('username')->get();
        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }
}
