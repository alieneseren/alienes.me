<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $profile = App\Models\Profile::first();

    if ($profile) {
        echo "=== PROFIL BİLGİLERİ ===\n";
        echo "ID: " . $profile->id . "\n";
        echo "Full Name: " . $profile->full_name . "\n";
        echo "Title: " . $profile->title . "\n";
        echo "Bio: " . $profile->bio . "\n";
        echo "Email: " . $profile->email . "\n";
        echo "GitHub Username: " . $profile->github_username . "\n";
        echo "GitHub Avatar URL: " . $profile->github_avatar_url . "\n";
        echo "GitHub Followers: " . $profile->github_followers . "\n";
        echo "GitHub Following: " . $profile->github_following . "\n";
        echo "GitHub Public Repos: " . $profile->github_public_repos . "\n";
        echo "GitHub Synced At: " . $profile->github_synced_at . "\n";
    } else {
        echo "Profil bulunamadı!\n";
    }
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage() . "\n";
}
