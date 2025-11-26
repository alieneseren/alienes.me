<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'title' => 'E-Ticaret Platformu',
            'description' => 'Modern bir e-ticaret platformu. Laravel backend, Vue.js frontend ile geliştirildi. Ödeme entegrasyonu, stok yönetimi ve kullanıcı paneli içerir.',
            'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'Stripe'],
            'demo_url' => 'https://demo.example.com',
            'github_url' => 'https://github.com/alienes/ecommerce',
            'is_featured' => true,
            'order' => 1,
        ]);

        Project::create([
            'title' => 'Proje Yönetim Sistemi',
            'description' => 'Takımlar için kapsamlı proje yönetim aracı. Görev takibi, zaman çizelgesi, dosya paylaşımı ve raporlama özellikleri.',
            'technologies' => ['Laravel', 'Livewire', 'AlpineJS', 'Tailwind CSS', 'PostgreSQL'],
            'demo_url' => 'https://pm-demo.example.com',
            'github_url' => 'https://github.com/alienes/project-manager',
            'is_featured' => true,
            'order' => 2,
        ]);

        Project::create([
            'title' => 'Blog Platformu',
            'description' => 'Markdown destekli, SEO uyumlu blog platformu. Kategori ve etiket sistemi, yorum modülü ve RSS feed desteği.',
            'technologies' => ['Laravel', 'React', 'MySQL', 'Elasticsearch'],
            'demo_url' => 'https://blog.example.com',
            'github_url' => 'https://github.com/alienes/blog-platform',
            'is_featured' => true,
            'order' => 3,
        ]);

        Project::create([
            'title' => 'API Gateway',
            'description' => 'Mikroservis mimarisi için API gateway çözümü. Rate limiting, authentication, logging ve monitoring özellikleri.',
            'technologies' => ['Laravel', 'Redis', 'Docker', 'Nginx'],
            'github_url' => 'https://github.com/alienes/api-gateway',
            'is_featured' => false,
            'order' => 4,
        ]);

        Project::create([
            'title' => 'Sosyal Medya Dashboard',
            'description' => 'Çoklu sosyal medya hesaplarını yönetmek için analitik dashboard. İstatistikler, post planlama ve raporlama.',
            'technologies' => ['Laravel', 'Vue.js', 'Chart.js', 'MySQL'],
            'demo_url' => 'https://social-dashboard.example.com',
            'is_featured' => false,
            'order' => 5,
        ]);

        Project::create([
            'title' => 'Öğrenci Bilgi Sistemi',
            'description' => 'Eğitim kurumları için kapsamlı öğrenci takip ve not yönetim sistemi. Veli portal ve mobil uygulama desteği.',
            'technologies' => ['Laravel', 'React Native', 'MySQL', 'Firebase'],
            'github_url' => 'https://github.com/alienes/student-system',
            'is_featured' => true,
            'order' => 6,
        ]);
    }
}
