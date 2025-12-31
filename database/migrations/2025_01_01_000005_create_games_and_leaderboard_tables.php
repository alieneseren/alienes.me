<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Games & Leaderboard Migration
 * 
 * Games portalı için oyun tanımları ve liderlik tablosu
 */
return new class extends Migration
{
    public function up(): void
    {
        // Oyunlar tablosu
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();          // Nasıl oynanır
            $table->string('thumbnail')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('category')->nullable();            // puzzle, arcade, strategy...
            $table->string('subdomain_path')->nullable();      // /snake, /tetris...
            
            // Oyun ayarları
            $table->json('config')->nullable();                // Oyun spesifik konfigürasyon
            $table->boolean('has_leaderboard')->default(true);
            $table->boolean('is_multiplayer')->default(false);
            $table->integer('max_players')->default(1);
            
            // Durum
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            
            // İstatistikler
            $table->integer('play_count')->default(0);
            $table->integer('unique_players')->default(0);
            
            $table->timestamps();
            
            $table->index(['is_active', 'is_featured']);
        });

        // Oyun skorları / Leaderboard
        Schema::create('game_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('player_name')->nullable();         // Misafir oyuncular için
            $table->bigInteger('score');
            $table->integer('level')->nullable();
            $table->integer('time_seconds')->nullable();       // Süre bazlı oyunlar için
            $table->json('metadata')->nullable();              // Oyun spesifik veriler
            $table->string('ip_hash')->nullable();             // Spam önleme
            $table->boolean('is_verified')->default(false);    // Anti-cheat
            $table->timestamps();
            
            $table->index(['game_id', 'score']);
            $table->index(['game_id', 'user_id']);
        });

        // Kullanıcı oyun istatistikleri
        Schema::create('user_game_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->integer('total_plays')->default(0);
            $table->bigInteger('highest_score')->default(0);
            $table->bigInteger('total_score')->default(0);
            $table->integer('total_time_seconds')->default(0);
            $table->integer('highest_level')->default(0);
            $table->timestamp('first_played_at');
            $table->timestamp('last_played_at');
            $table->timestamps();
            
            $table->unique(['user_id', 'game_id']);
        });

        // Günlük/Haftalık/Aylık liderlik tabloları
        Schema::create('leaderboard_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->enum('period', ['daily', 'weekly', 'monthly', 'all_time']);
            $table->date('period_start');
            $table->date('period_end');
            $table->json('rankings');                          // Top 100 sıralama
            $table->timestamps();
            
            $table->unique(['game_id', 'period', 'period_start']);
        });

        // Kullanıcı başarımları (achievements tablosuyla ilişki)
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->integer('progress')->default(0);           // İlerleme yüzdesi
            $table->boolean('is_completed')->default(false);
            $table->timestamp('unlocked_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'achievement_id']);
        });

        // Aktif oyun oturumları (multiplayer için)
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('session_code')->unique();          // Benzersiz oda kodu
            $table->foreignId('host_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->json('players')->nullable();               // Oyuncu listesi
            $table->enum('status', ['waiting', 'playing', 'finished'])->default('waiting');
            $table->json('game_state')->nullable();            // Oyun durumu
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            
            $table->index(['game_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_sessions');
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('leaderboard_snapshots');
        Schema::dropIfExists('user_game_stats');
        Schema::dropIfExists('game_scores');
        Schema::dropIfExists('games');
    }
};
