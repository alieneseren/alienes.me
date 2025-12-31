<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Achievements System Migration
 * 
 * Global başarım sistemi - tüm subdomainlerde kullanılabilir
 * Games, Study ve Portfolio modülleri için rozetler
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');                           // Başarım adı
            $table->string('slug')->unique();                 // URL-friendly slug
            $table->text('description');                      // Açıklama
            $table->string('icon')->nullable();               // Lucide icon adı
            $table->string('badge_color')->default('#3b82f6'); // Rozet rengi
            $table->string('module')->default('global');       // games, study, portfolio, global
            $table->enum('rarity', ['common', 'rare', 'epic', 'legendary'])->default('common');
            $table->json('criteria')->nullable();              // Kazanma kriterleri JSON
            $table->integer('xp_reward')->default(0);         // XP ödülü
            $table->boolean('is_secret')->default(false);     // Gizli başarım mı?
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['module', 'is_active']);
        });

        // User-Achievement pivot table
        Schema::create('achievement_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->timestamp('unlocked_at');
            $table->json('metadata')->nullable();             // Ek bilgiler (hangi oyun, hangi ders vs)
            
            $table->unique(['user_id', 'achievement_id']);
            $table->index('unlocked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievement_user');
        Schema::dropIfExists('achievements');
    }
};
