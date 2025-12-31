<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GitHubService
{
    protected $token;
    protected $username;
    protected $baseUrl = 'https://api.github.com';

    public function __construct()
    {
        $this->token = config('services.github.token');
        $this->username = config('services.github.username');
    }

    /**
     * Get user's repositories from GitHub
     */
    public function getRepositories($username = null)
    {
        $username = $username ?: $this->username;
        
        if (!$username) {
            return [];
        }

        // Cache for 1 hour
        return Cache::remember("github_repos_{$username}", 3600, function () use ($username) {
            try {
                $response = Http::timeout(30)
                    ->withHeaders($this->getHeaders())
                    ->get("{$this->baseUrl}/users/{$username}/repos", [
                        'sort' => 'updated',
                        'per_page' => 100,
                    ]);

                if ($response->successful()) {
                    return collect($response->json())
                        ->filter(function ($repo) {
                            return !$repo['fork']; // Exclude forked repos
                        })
                        ->map(function ($repo) {
                            return [
                                'id' => $repo['id'],
                                'name' => $repo['name'],
                                'full_name' => $repo['full_name'],
                                'description' => $repo['description'] ?? '',
                                'html_url' => $repo['html_url'],
                                'homepage' => $repo['homepage'] ?? '',
                                'language' => $repo['language'] ?? 'Unknown',
                                'topics' => $repo['topics'] ?? [],
                                'stargazers_count' => $repo['stargazers_count'] ?? 0,
                                'forks_count' => $repo['forks_count'] ?? 0,
                                'created_at' => $repo['created_at'],
                                'updated_at' => $repo['updated_at'],
                                'pushed_at' => $repo['pushed_at'],
                            ];
                        })
                        ->sortByDesc('updated_at')
                        ->values()
                        ->toArray();
                } else {
                    \Log::error("GitHub API Error: HTTP {$response->status()} - " . $response->body());
                }
            } catch (\Exception $e) {
                \Log::error('GitHub API Error: ' . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Get single repository details
     */
    public function getRepository($owner, $repo)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/repos/{$owner}/{$repo}");

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'full_name' => $data['full_name'],
                    'description' => $data['description'] ?? '',
                    'html_url' => $data['html_url'],
                    'homepage' => $data['homepage'] ?? '',
                    'language' => $data['language'] ?? 'Unknown',
                    'topics' => $data['topics'] ?? [],
                    'stargazers_count' => $data['stargazers_count'] ?? 0,
                    'forks_count' => $data['forks_count'] ?? 0,
                ];
            } else {
                \Log::error("GitHub API Error: HTTP {$response->status()} for {$owner}/{$repo}");
            }
        } catch (\Exception $e) {
            \Log::error("GitHub API Error fetching {$owner}/{$repo}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get repository README
     */
    public function getReadme($owner, $repo)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/repos/{$owner}/{$repo}/readme");

            if ($response->successful()) {
                $data = $response->json();
                return base64_decode($data['content']);
            }
        } catch (\Exception $e) {
            \Log::error("GitHub API Error fetching README for {$owner}/{$repo}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get GitHub user profile
     */
    public function getUserProfile($username = null)
    {
        $username = $username ?: $this->username;
        
        if (!$username) {
            return null;
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/users/{$username}");

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'login' => $data['login'],
                    'name' => $data['name'],
                    'avatar_url' => $data['avatar_url'],
                    'bio' => $data['bio'],
                    'company' => $data['company'],
                    'blog' => $data['blog'],
                    'location' => $data['location'],
                    'email' => $data['email'],
                    'twitter_username' => $data['twitter_username'],
                    'public_repos' => $data['public_repos'],
                    'followers' => $data['followers'],
                    'following' => $data['following'],
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['updated_at'],
                ];
            } else {
                \Log::error("GitHub API Error: HTTP {$response->status()} for user {$username}");
            }
        } catch (\Exception $e) {
            \Log::error("GitHub API Error fetching user {$username}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Clear repository cache
     */
    public function clearCache($username = null)
    {
        $username = $username ?: $this->username;
        Cache::forget("github_repos_{$username}");
    }

    /**
     * Get request headers
     */
    protected function getHeaders()
    {
        $headers = [
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'Laravel-Portfolio-App',
        ];

        if ($this->token) {
            $headers['Authorization'] = "Bearer {$this->token}";
        }

        return $headers;
    }
}
