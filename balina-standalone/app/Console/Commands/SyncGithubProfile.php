<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncGithubProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:sync {username?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GitHub profilini senkronize et';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $profile = Profile::first();
        
        if (!$profile) {
            $this->error('Profil kaydı bulunamadı!');
            return 1;
        }
        
        $username = $this->argument('username') ?? $profile->github_username ?? 'alieneseren';
        
        try {
            $this->info("GitHub profili senkronize ediliyor: {$username}");
            
            $response = Http::get("https://api.github.com/users/{$username}");
            
            if (!$response->successful()) {
                $this->error("GitHub API'den veri alınamadı!");
                return 1;
            }
            
            $data = $response->json();
            
            // Profili güncelle
            $profile->update([
                'github_username' => $data['login'],
                'github_avatar_url' => $data['avatar_url'],
                'github_bio' => $data['bio'],
                'github_company' => $data['company'],
                'github_blog' => $data['blog'],
                'github_followers' => $data['followers'],
                'github_following' => $data['following'],
                'github_public_repos' => $data['public_repos'],
                'github_synced_at' => now(),
            ]);
            
            $this->info('✓ GitHub profili başarıyla senkronize edildi!');
            $this->info('');
            $this->info('Bilgiler:');
            $this->info('  - Avatar: ' . $data['avatar_url']);
            $this->info('  - Bio: ' . $data['bio']);
            $this->info('  - Takipçiler: ' . $data['followers']);
            $this->info('  - Repo\'lar: ' . $data['public_repos']);
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Hata: ' . $e->getMessage());
            return 1;
        }
    }
}
