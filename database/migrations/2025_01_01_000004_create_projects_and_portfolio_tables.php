<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Projects & Portfolio Migration
 * 
 * Ana site için proje vitrini, teknoloji stack tracking
 */
return new class extends Migration
{
    public function up(): void
    {
        // Projeler tablosu
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('long_description')->nullable();      // Markdown detaylı açıklama
            $table->string('thumbnail')->nullable();
            $table->json('screenshots')->nullable();           // Proje ekran görüntüleri
            $table->string('live_url')->nullable();            // Canlı demo linki
            $table->string('github_url')->nullable();          // GitHub repo
            $table->string('subdomain')->nullable();           // balina, study, games...
            
            // Kategorilendirme
            $table->string('category')->nullable();            // web, mobile, ai, game...
            $table->json('technologies')->nullable();          // ['Laravel', 'Vue.js', 'TailwindCSS']
            $table->json('features')->nullable();              // Özellikler listesi
            
            // Durum & Görünürlük
            $table->enum('status', ['planning', 'in_progress', 'completed', 'archived'])->default('in_progress');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->date('completed_at')->nullable();
            $table->integer('order')->default(0);
            
            // Metrikler
            $table->integer('view_count')->default(0);
            $table->integer('like_count')->default(0);
            
            $table->timestamps();
            
            $table->index(['is_published', 'is_featured']);
            $table->index('status');
        });

        // Proje teknolojileri (many-to-many için ayrı tablo)
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();               // Heroicon veya özel SVG
            $table->string('color')->nullable();              // Tailwind renk kodu
            $table->string('category')->nullable();           // frontend, backend, database, devops...
            $table->string('website_url')->nullable();
            $table->integer('proficiency')->default(50);      // 0-100 yetkinlik seviyesi
            $table->timestamps();
        });

        // Proje-Teknoloji ilişkisi
        Schema::create('project_technology', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('technology_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['project_id', 'technology_id']);
        });

        // Proje yorumları / geri bildirimler
        Schema::create('project_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('guest_name')->nullable();         // Misafir yorumları için
            $table->string('guest_email')->nullable();
            $table->text('content');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            
            $table->index(['project_id', 'is_approved']);
        });

        // Blog / yazılar (proje detayları, tutorial'lar)
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');                       // Markdown içerik
            $table->string('cover_image')->nullable();
            $table->json('tags')->nullable();
            $table->enum('type', ['blog', 'tutorial', 'changelog', 'announcement'])->default('blog');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('reading_time')->default(5);       // Dakika cinsinden
            $table->timestamps();
            
            $table->index(['is_published', 'published_at']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('project_comments');
        Schema::dropIfExists('project_technology');
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('projects');
    }
};
