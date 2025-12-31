<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CourseProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Study Service
 * 
 * Kurs, modül ve quiz yönetimi için servis
 */
class StudyService
{
    protected const CACHE_TTL = 1800; // 30 dakika

    /**
     * Kursları getir
     */
    public function getCourses(array $filters = []): Collection
    {
        $query = Course::query()
            ->withCount('modules')
            ->where('is_published', true);

        if (!empty($filters['difficulty'])) {
            $query->where('difficulty', $filters['difficulty']);
        }

        if (!empty($filters['featured'])) {
            $query->where('is_featured', true);
        }

        return $query->orderBy('order')->get();
    }

    /**
     * Öne çıkan kursları getir
     */
    public function getFeaturedCourses(int $limit = 4): Collection
    {
        return Cache::remember('courses.featured', self::CACHE_TTL, function () use ($limit) {
            return Course::query()
                ->withCount('modules')
                ->where('is_published', true)
                ->where('is_featured', true)
                ->orderBy('order')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Tek kurs getir (modüller ile)
     */
    public function getCourseBySlug(string $slug, ?int $userId = null): ?Course
    {
        $course = Course::query()
            ->with(['modules' => function ($q) {
                $q->orderBy('order');
            }])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if ($course && $userId) {
            $course->userProgress = $this->getUserProgress($userId, $course->id);
        }

        return $course;
    }

    /**
     * Kullanıcı ilerleme durumu
     */
    public function getUserProgress(int $userId, int $courseId): ?CourseProgress
    {
        return CourseProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();
    }

    /**
     * Kursa başla
     */
    public function startCourse(int $userId, Course $course): CourseProgress
    {
        return CourseProgress::firstOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $course->id,
            ],
            [
                'total_modules' => $course->modules()->count(),
                'started_at' => now(),
            ]
        );
    }

    /**
     * Modülü tamamla
     */
    public function completeModule(int $userId, CourseModule $module): void
    {
        DB::transaction(function () use ($userId, $module) {
            // Modülü tamamlandı olarak işaretle
            DB::table('completed_modules')->insertOrIgnore([
                'user_id' => $userId,
                'course_module_id' => $module->id,
                'completed_at' => now(),
            ]);

            // İlerlemeyi güncelle
            $progress = CourseProgress::firstOrCreate(
                [
                    'user_id' => $userId,
                    'course_id' => $module->course_id,
                ],
                [
                    'total_modules' => $module->course->modules()->count(),
                    'started_at' => now(),
                ]
            );

            $completedCount = DB::table('completed_modules')
                ->where('user_id', $userId)
                ->whereIn('course_module_id', $module->course->modules()->pluck('id'))
                ->count();

            $progress->completed_modules = $completedCount;
            $progress->progress_percentage = $progress->total_modules > 0 
                ? round(($completedCount / $progress->total_modules) * 100)
                : 0;

            // Kurs tamamlandı mı?
            if ($progress->progress_percentage >= 100) {
                $progress->completed_at = now();
            }

            // Sonraki modülü ayarla
            $nextModule = CourseModule::where('course_id', $module->course_id)
                ->where('order', '>', $module->order)
                ->orderBy('order')
                ->first();

            if ($nextModule) {
                $progress->current_module_id = $nextModule->id;
            }

            $progress->save();
        });
    }

    /**
     * Quiz başlat
     */
    public function startQuiz(int $userId, Quiz $quiz): QuizAttempt
    {
        return QuizAttempt::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
            'started_at' => now(),
        ]);
    }

    /**
     * Quiz cevapla
     */
    public function submitQuizAnswers(QuizAttempt $attempt, array $answers): QuizAttempt
    {
        $quiz = $attempt->quiz()->with('questions')->first();
        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($quiz->questions as $question) {
            $totalPoints += $question->points;
            $userAnswer = $answers[$question->id] ?? null;
            
            if ($this->checkAnswer($question, $userAnswer)) {
                $earnedPoints += $question->points;
            }
        }

        $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;

        $attempt->update([
            'answers' => $answers,
            'score' => $earnedPoints,
            'total_points' => $totalPoints,
            'percentage' => $percentage,
            'passed' => $percentage >= $quiz->passing_score,
            'time_taken_seconds' => now()->diffInSeconds($attempt->started_at),
            'completed_at' => now(),
        ]);

        return $attempt;
    }

    /**
     * Cevap kontrolü
     */
    protected function checkAnswer($question, $userAnswer): bool
    {
        if ($userAnswer === null) {
            return false;
        }

        $correctAnswer = $question->correct_answer;

        // Tip bazlı kontrol
        switch ($question->type) {
            case 'true_false':
                return strtolower($userAnswer) === strtolower($correctAnswer);
            
            case 'multiple_choice':
                return $userAnswer === $correctAnswer;
            
            case 'short_answer':
                // Basit string karşılaştırma
                return strtolower(trim($userAnswer)) === strtolower(trim($correctAnswer));
        }

        return false;
    }

    /**
     * Kullanıcının tüm kurs ilerlemeleri
     */
    public function getUserAllProgress(int $userId): Collection
    {
        return CourseProgress::query()
            ->with('course')
            ->where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->get();
    }

    /**
     * Quiz sonuçları
     */
    public function getUserQuizResults(int $userId, ?int $quizId = null): Collection
    {
        $query = QuizAttempt::query()
            ->with(['quiz.module.course'])
            ->where('user_id', $userId)
            ->whereNotNull('completed_at');

        if ($quizId) {
            $query->where('quiz_id', $quizId);
        }

        return $query->orderByDesc('completed_at')->get();
    }

    /**
     * İstatistikler
     */
    public function getStats(): array
    {
        return Cache::remember('study.stats', self::CACHE_TTL, function () {
            return [
                'total_courses' => Course::where('is_published', true)->count(),
                'total_modules' => CourseModule::count(),
                'total_quizzes' => Quiz::count(),
                'total_enrollments' => CourseProgress::count(),
                'completed_courses' => CourseProgress::whereNotNull('completed_at')->count(),
            ];
        });
    }

    /**
     * Cache temizle
     */
    public function clearCache(): void
    {
        Cache::forget('courses.featured');
        Cache::forget('study.stats');
    }
}
