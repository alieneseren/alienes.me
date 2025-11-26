<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function getGithubUser()
    {
        $githubUsername = 'alieneseren';
        
        // 1 saat boyunca cache'le
        $userData = Cache::remember("github_user_{$githubUsername}", 3600, function () use ($githubUsername) {
            try {
                $response = Http::get("https://api.github.com/users/{$githubUsername}");
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            } catch (\Exception $e) {
                return null;
            }
        });
        
        return response()->json($userData);
    }
    
    public function getGithubAvatar()
    {
        $githubUsername = 'alieneseren';
        
        // 1 saat boyunca cache'le
        $avatarUrl = Cache::remember("github_avatar_{$githubUsername}", 3600, function () use ($githubUsername) {
            try {
                $response = Http::get("https://api.github.com/users/{$githubUsername}");
                
                if ($response->successful()) {
                    $data = $response->json();
                    return $data['avatar_url'] ?? null;
                }
                
                return null;
            } catch (\Exception $e) {
                return null;
            }
        });
        
        if ($avatarUrl) {
            // Avatar URL'sini redirect yap
            return redirect($avatarUrl);
        }
        
        // Fallback: placehold.co kullan
        return redirect('https://placehold.co/320x320?text=AE');
    }
}
