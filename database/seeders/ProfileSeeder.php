<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::create([
            'full_name' => 'Ali Enes',
            'title' => 'Full Stack Developer & Software Engineer',
            'bio' => "Merhaba! Ben Ali Enes, yazılım geliştirme alanında tutkulu bir profesyonelim. Modern web teknolojileri ve yenilikçi çözümler konusunda uzmanlaşmış durumdayım.\n\nBackend ve frontend geliştirme konularında geniş deneyime sahibim. Laravel, PHP, JavaScript ve modern frameworkler ile çalışmaktan keyif alıyorum.\n\nProjelerde kod kalitesi, performans ve kullanıcı deneyimine önem veriyorum. Sürekli öğrenme ve gelişim felsefesiyle hareket ediyorum.",
            'email' => 'contact@alienes.me',
            'phone' => '+90 555 123 4567',
            'location' => 'İstanbul, Türkiye',
            'github_url' => 'https://github.com/alienes',
            'linkedin_url' => 'https://linkedin.com/in/alienes',
            'twitter_url' => 'https://twitter.com/alienes',
        ]);
    }
}
