<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Services\GitHubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate([]);
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bio' => 'required|string',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'github_url' => 'nullable|url',
            'github_username' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'resume_url' => 'nullable|url',
        ]);

        $profile = Profile::firstOrCreate([]);
        $data = $request->except('profile_image');

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            try {
                // Delete old image if exists
                if ($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                    Storage::disk('public')->delete($profile->profile_image);
                }
                
                // Store new image with unique name
                $file = $request->file('profile_image');
                $filename = 'profiles/' . uniqid('profile_') . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profiles', basename($filename), 'public');
                
                if ($path) {
                    $data['profile_image'] = $path;
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Resim yükleme sırasında hata oluştu: ' . $e->getMessage());
            }
        }

        try {
            $profile->update($data);
            return redirect()->route('admin.profile.edit')->with('success', 'Profil başarıyla güncellendi.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Profil güncellenirken hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Sync profile from GitHub
     */
    public function syncFromGithub(Request $request, GitHubService $github)
    {
        $profile = Profile::firstOrCreate([]);
        
        $username = $request->input('username') ?: $profile->github_username ?: config('services.github.username');
        
        if (!$username) {
            return redirect()->back()->with('error', 'GitHub kullanıcı adı belirtilmedi.');
        }

        $githubData = $github->getUserProfile($username);

        if (!$githubData) {
            return redirect()->back()->with('error', 'GitHub profiliniz çekilemedi. Lütfen kullanıcı adını kontrol edin.');
        }

        // Update profile with GitHub data
        $profile->update([
            'github_username' => $githubData['login'],
            'github_avatar_url' => $githubData['avatar_url'],
            'github_bio' => $githubData['bio'],
            'github_company' => $githubData['company'],
            'github_blog' => $githubData['blog'],
            'github_followers' => $githubData['followers'],
            'github_following' => $githubData['following'],
            'github_public_repos' => $githubData['public_repos'],
            'github_synced_at' => now(),
            'github_url' => 'https://github.com/' . $githubData['login'],
        ]);

        // If profile doesn't have name/bio, use GitHub data
        if (empty($profile->full_name) && !empty($githubData['name'])) {
            $profile->update(['full_name' => $githubData['name']]);
        }
        
        if (empty($profile->bio) && !empty($githubData['bio'])) {
            $profile->update(['bio' => $githubData['bio']]);
        }

        if (empty($profile->location) && !empty($githubData['location'])) {
            $profile->update(['location' => $githubData['location']]);
        }

        return redirect()->back()->with('success', 'GitHub profiliniz başarıyla senkronize edildi!');
    }

    /**
     * Delete profile image
     */
    public function deleteImage()
    {
        $profile = Profile::firstOrCreate([]);

        if ($profile->profile_image) {
            Storage::disk('public')->delete($profile->profile_image);
            $profile->update(['profile_image' => null]);
            return redirect()->back()->with('success', 'Profil fotoğrafı silindi.');
        }

        return redirect()->back()->with('error', 'Silinecek fotoğraf bulunamadı.');
    }
}
