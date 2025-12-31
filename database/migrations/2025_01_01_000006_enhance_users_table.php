<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Enhanced Users & Global Auth Migration
 * 
 * Kullanıcı tablosuna global auth ve profil alanları ekleme
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profil bilgileri
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('avatar')->nullable()->after('email');
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->json('social_links')->nullable();          // GitHub, LinkedIn, Twitter...
            
            // Gamification
            $table->integer('total_points')->default(0);
            $table->integer('level')->default(1);
            $table->integer('experience')->default(0);
            $table->string('rank_title')->nullable();          // Çaylak, Usta, Efsane...
            
            // Global auth tokenleri (subdomain arası)
            $table->string('global_token')->nullable();
            $table->timestamp('global_token_expires_at')->nullable();
            
            // Tercihler
            $table->json('preferences')->nullable();           // Tema, dil, bildirimler...
            $table->string('timezone')->default('Europe/Istanbul');
            $table->string('locale')->default('tr');
            
            // İstatistikler
            $table->timestamp('last_activity_at')->nullable();
            $table->integer('streak_days')->default(0);        // Ardışık giriş günleri
            $table->date('streak_last_date')->nullable();
            
            // Sosyal giriş
            $table->string('google_id')->nullable();
            $table->string('github_id')->nullable();
            
            // Durum
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_banned')->default(false);
            
            // Indexler
            $table->index('username');
            $table->index('total_points');
            $table->index('global_token');
        });

        // Kullanıcı aktivite log'u
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');                            // login, course_complete, game_play, achievement...
            $table->string('subject_type')->nullable();        // Model tipi
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->json('data')->nullable();                  // Ek veriler
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'created_at']);
        });

        // Kullanıcı bildirimleri
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');                            // achievement, course, system...
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('icon')->nullable();
            $table->string('action_url')->nullable();
            $table->json('data')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
        });

        // Global oturum tablosu (subdomain senkronizasyonu)
        Schema::create('global_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('token', 64)->unique();
            $table->string('subdomain')->nullable();           // balina, study, games...
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
            
            $table->index(['token', 'expires_at']);
            $table->index(['user_id', 'subdomain']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('global_sessions');
        Schema::dropIfExists('user_notifications');
        Schema::dropIfExists('user_activities');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['username']);
            $table->dropIndex(['total_points']);
            $table->dropIndex(['global_token']);
            
            $table->dropColumn([
                'username', 'avatar', 'bio', 'location', 'website', 'social_links',
                'total_points', 'level', 'experience', 'rank_title',
                'global_token', 'global_token_expires_at',
                'preferences', 'timezone', 'locale',
                'last_activity_at', 'streak_days', 'streak_last_date',
                'google_id', 'github_id',
                'is_admin', 'is_verified', 'is_banned'
            ]);
        });
    }
};
