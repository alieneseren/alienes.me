<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrateLegacyDataCommand extends Command
{
    protected $signature = 'app:migrate-legacy-data {--dry-run : Migration önizleme, değişiklik yapmaz}';
    
    protected $description = 'Eski veri yapısını yeni FilamentPHP uyumlu yapıya dönüştür';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('🔍 DRY-RUN MODU - Değişiklik yapılmayacak');
        }

        $this->info('Veritabanı veri dönüşümü başlıyor...');

        // 1. Blog posts slug kontrolü
        $this->migrateBlogPostSlugs($dryRun);
        
        // 2. Mevcut tablo sayılarını göster
        $this->showTableCounts();

        $this->info('✅ Veri dönüşümü tamamlandı!');
        
        return Command::SUCCESS;
    }

    protected function migrateBlogPostSlugs(bool $dryRun): void
    {
        $this->info('📝 Blog yazıları kontrol ediliyor...');

        try {
            $posts = DB::table('blog_posts')
                ->whereNull('slug')
                ->orWhere('slug', '')
                ->get();

            if ($posts->isEmpty()) {
                $this->info('   ✓ Tüm blog yazılarında slug mevcut.');
                return;
            }

            foreach ($posts as $post) {
                $title = $post->title ?? 'post-' . $post->id;
                $slug = Str::slug($title);
                
                // Unique slug oluştur
                $counter = 1;
                $originalSlug = $slug;
                while (DB::table('blog_posts')->where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $this->line("   • ID {$post->id}: slug = '{$slug}'");

                if (!$dryRun) {
                    DB::table('blog_posts')
                        ->where('id', $post->id)
                        ->update(['slug' => $slug]);
                }
            }

            $this->info("   ✓ {$posts->count()} yazının slug'ı güncellendi.");
        } catch (\Exception $e) {
            $this->warn("   ⚠ Blog posts tablosu mevcut değil veya boş: " . $e->getMessage());
        }
    }

    protected function showTableCounts(): void
    {
        $this->info('📊 Tablo özeti:');

        $tables = [
            'users' => 'Kullanıcılar',
            'blog_posts' => 'Blog Yazıları',
            'projects' => 'Projeler',
            'games' => 'Oyunlar',
            'tags' => 'Etiketler',
        ];

        foreach ($tables as $table => $label) {
            try {
                $count = DB::table($table)->count();
                $this->line("   • {$label}: {$count} kayıt");
            } catch (\Exception $e) {
                $this->line("   • {$label}: Tablo mevcut değil");
            }
        }
    }
}
