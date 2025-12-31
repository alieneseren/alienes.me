<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Courses System Migration (LMS)
 * 
 * Study portalı için kurs, modül ve quiz sistemi
 */
return new class extends Migration
{
    public function up(): void
    {
        // Kurslar tablosu
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('difficulty')->default('beginner'); // beginner, intermediate, advanced
            $table->integer('estimated_hours')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            $table->timestamps();
            
            $table->index(['is_published', 'is_featured']);
        });

        // Kurs modülleri
        Schema::create('course_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();              // Markdown içerik
            $table->string('video_url')->nullable();
            $table->integer('duration_minutes')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_free')->default(false);       // Ücretsiz erişim
            $table->timestamps();
            
            $table->unique(['course_id', 'slug']);
            $table->index('order');
        });

        // Quiz tablosu
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_module_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('time_limit_minutes')->nullable();
            $table->integer('passing_score')->default(70);    // Geçme puanı %
            $table->boolean('shuffle_questions')->default(true);
            $table->boolean('show_correct_answers')->default(true);
            $table->timestamps();
        });

        // Quiz soruları
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer'])->default('multiple_choice');
            $table->json('options')->nullable();              // Çoktan seçmeli cevaplar
            $table->string('correct_answer');
            $table->text('explanation')->nullable();          // Cevap açıklaması
            $table->integer('points')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Kullanıcı quiz sonuçları
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->integer('total_points')->default(0);
            $table->integer('percentage')->default(0);
            $table->boolean('passed')->default(false);
            $table->integer('time_taken_seconds')->nullable();
            $table->json('answers')->nullable();              // Kullanıcı cevapları
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'quiz_id']);
        });

        // Kullanıcı kurs ilerleme durumu
        Schema::create('course_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('current_module_id')->nullable()->constrained('course_modules')->onDelete('set null');
            $table->integer('completed_modules')->default(0);
            $table->integer('total_modules')->default(0);
            $table->integer('progress_percentage')->default(0);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'course_id']);
        });

        // Tamamlanan modüller
        Schema::create('completed_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_module_id')->constrained()->onDelete('cascade');
            $table->timestamp('completed_at');
            
            $table->unique(['user_id', 'course_module_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('completed_modules');
        Schema::dropIfExists('course_progress');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('course_modules');
        Schema::dropIfExists('courses');
    }
};
