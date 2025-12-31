<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Flashcard System Migration
 * 
 * Study portalı için Anki/Quizlet tarzı flashcard sistemi
 * Spaced repetition (SM-2) algoritması desteği
 */
return new class extends Migration
{
    public function up(): void
    {
        // Flashcard desteleri
        Schema::create('flashcard_decks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // null = sistem destesi
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('category')->nullable();           // Matematik, Fizik, Programlama...
            $table->integer('card_count')->default(0);
            $table->boolean('is_public')->default(false);     // Herkese açık mı
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'is_public']);
            $table->index('category');
        });

        // Flashcard kartları
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deck_id')->constrained('flashcard_decks')->onDelete('cascade');
            $table->text('front');                            // Ön yüz (soru)
            $table->text('back');                             // Arka yüz (cevap)
            $table->text('hint')->nullable();                 // İpucu
            $table->string('media_front')->nullable();        // Ön yüz medya (resim/ses)
            $table->string('media_back')->nullable();         // Arka yüz medya
            $table->json('tags')->nullable();                 // Etiketler
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index('deck_id');
        });

        // Kullanıcı flashcard ilerleme durumu (SM-2 Spaced Repetition)
        Schema::create('flashcard_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('flashcard_id')->constrained()->onDelete('cascade');
            
            // SM-2 Algorithm fields
            $table->float('easiness_factor')->default(2.5);   // EF değeri (1.3-2.5)
            $table->integer('interval')->default(0);          // Gün cinsinden aralık
            $table->integer('repetitions')->default(0);       // Tekrar sayısı
            
            // Performans metrikleri
            $table->integer('correct_count')->default(0);
            $table->integer('incorrect_count')->default(0);
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamp('next_review_at')->nullable();  // Sonraki tekrar zamanı
            
            $table->timestamps();
            
            $table->unique(['user_id', 'flashcard_id']);
            $table->index(['user_id', 'next_review_at']);
        });

        // Çalışma oturumları
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('deck_id')->constrained('flashcard_decks')->onDelete('cascade');
            $table->integer('cards_studied')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->integer('incorrect_answers')->default(0);
            $table->integer('duration_seconds')->default(0);
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'started_at']);
        });

        // Favori desteler
        Schema::create('deck_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('deck_id')->constrained('flashcard_decks')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'deck_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deck_favorites');
        Schema::dropIfExists('study_sessions');
        Schema::dropIfExists('flashcard_progress');
        Schema::dropIfExists('flashcards');
        Schema::dropIfExists('flashcard_decks');
    }
};
