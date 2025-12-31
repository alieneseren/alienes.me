<?php

namespace App\Services;

use App\Models\FlashcardDeck;
use App\Models\Flashcard;
use App\Models\FlashcardProgress;
use App\Models\StudySession;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Flashcard Service
 * 
 * Flashcard sistemi ve SM-2 Spaced Repetition algoritması
 */
class FlashcardService
{
    protected const CACHE_TTL = 1800; // 30 dakika

    // SM-2 Algoritma sabitleri
    protected const MIN_EASINESS = 1.3;
    protected const MAX_EASINESS = 2.5;
    protected const DEFAULT_EASINESS = 2.5;

    /**
     * Desteleri getir
     */
    public function getDecks(?int $userId = null, bool $publicOnly = false): Collection
    {
        $query = FlashcardDeck::query()
            ->withCount('flashcards');

        if ($publicOnly) {
            $query->where('is_public', true);
        } elseif ($userId) {
            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhere('is_public', true);
            });
        }

        return $query->orderByDesc('is_featured')
            ->orderBy('title')
            ->get();
    }

    /**
     * Öne çıkan desteleri getir
     */
    public function getFeaturedDecks(int $limit = 6): Collection
    {
        return Cache::remember('flashcards.featured', self::CACHE_TTL, function () use ($limit) {
            return FlashcardDeck::query()
                ->withCount('flashcards')
                ->where('is_public', true)
                ->where('is_featured', true)
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Tek deste getir
     */
    public function getDeckBySlug(string $slug, ?int $userId = null): ?FlashcardDeck
    {
        $query = FlashcardDeck::query()
            ->with('flashcards')
            ->where('slug', $slug);

        if ($userId) {
            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhere('is_public', true);
            });
        } else {
            $query->where('is_public', true);
        }

        return $query->first();
    }

    /**
     * Çalışılacak kartları getir (SM-2 algoritmasına göre)
     */
    public function getCardsForStudy(int $userId, FlashcardDeck $deck, int $limit = 20): Collection
    {
        $now = now();

        // Tekrar zamanı gelmiş kartlar
        $dueCards = Flashcard::query()
            ->join('flashcard_progress', 'flashcards.id', '=', 'flashcard_progress.flashcard_id')
            ->where('flashcards.deck_id', $deck->id)
            ->where('flashcard_progress.user_id', $userId)
            ->where('flashcard_progress.next_review_at', '<=', $now)
            ->select('flashcards.*')
            ->orderBy('flashcard_progress.next_review_at')
            ->limit($limit)
            ->get();

        // Eğer yeterli kart yoksa, hiç çalışılmamış kartları ekle
        $remaining = $limit - $dueCards->count();
        if ($remaining > 0) {
            $newCards = Flashcard::query()
                ->where('deck_id', $deck->id)
                ->whereNotIn('id', function ($q) use ($userId) {
                    $q->select('flashcard_id')
                      ->from('flashcard_progress')
                      ->where('user_id', $userId);
                })
                ->limit($remaining)
                ->get();

            $dueCards = $dueCards->concat($newCards);
        }

        return $dueCards;
    }

    /**
     * Kart cevapla (SM-2 algoritması)
     * 
     * @param int $quality Cevap kalitesi (0-5)
     *   0: Hiç hatırlamadı
     *   1: Yanlış cevap, doğru cevabı görünce hatırladı
     *   2: Yanlış cevap, doğru cevabı görünce "ah evet" dedi
     *   3: Doğru cevap, zorlandı
     *   4: Doğru cevap, düşündükten sonra
     *   5: Doğru cevap, anında
     */
    public function recordAnswer(int $userId, Flashcard $flashcard, int $quality): FlashcardProgress
    {
        $quality = max(0, min(5, $quality));
        
        $progress = FlashcardProgress::firstOrNew([
            'user_id' => $userId,
            'flashcard_id' => $flashcard->id,
        ], [
            'easiness_factor' => self::DEFAULT_EASINESS,
            'interval' => 0,
            'repetitions' => 0,
        ]);

        // SM-2 Algoritması
        if ($quality >= 3) {
            // Doğru cevap
            $progress->correct_count++;
            
            if ($progress->repetitions === 0) {
                $progress->interval = 1;
            } elseif ($progress->repetitions === 1) {
                $progress->interval = 6;
            } else {
                $progress->interval = (int) round($progress->interval * $progress->easiness_factor);
            }
            
            $progress->repetitions++;
        } else {
            // Yanlış cevap - sıfırla
            $progress->incorrect_count++;
            $progress->repetitions = 0;
            $progress->interval = 1;
        }

        // Easiness Factor güncelleme
        $progress->easiness_factor = max(
            self::MIN_EASINESS,
            $progress->easiness_factor + (0.1 - (5 - $quality) * (0.08 + (5 - $quality) * 0.02))
        );

        // Sonraki tekrar zamanı
        $progress->last_reviewed_at = now();
        $progress->next_review_at = now()->addDays($progress->interval);
        
        $progress->save();

        return $progress;
    }

    /**
     * Çalışma oturumu başlat
     */
    public function startSession(int $userId, FlashcardDeck $deck): StudySession
    {
        return StudySession::create([
            'user_id' => $userId,
            'deck_id' => $deck->id,
            'started_at' => now(),
        ]);
    }

    /**
     * Çalışma oturumu bitir
     */
    public function endSession(StudySession $session, array $stats): StudySession
    {
        $session->update([
            'cards_studied' => $stats['total'] ?? 0,
            'correct_answers' => $stats['correct'] ?? 0,
            'incorrect_answers' => $stats['incorrect'] ?? 0,
            'duration_seconds' => now()->diffInSeconds($session->started_at),
            'ended_at' => now(),
        ]);

        return $session;
    }

    /**
     * Kullanıcı istatistikleri
     */
    public function getUserStats(int $userId): array
    {
        $progress = FlashcardProgress::where('user_id', $userId);
        $sessions = StudySession::where('user_id', $userId);

        return [
            'total_cards_studied' => $progress->count(),
            'total_correct' => $progress->sum('correct_count'),
            'total_incorrect' => $progress->sum('incorrect_count'),
            'total_sessions' => $sessions->count(),
            'total_study_time' => $sessions->sum('duration_seconds'),
            'average_accuracy' => $this->calculateAccuracy($userId),
            'streak' => $this->calculateStreak($userId),
            'cards_due_today' => $this->getCardsDueCount($userId),
        ];
    }

    /**
     * Doğruluk oranı hesapla
     */
    protected function calculateAccuracy(int $userId): float
    {
        $totals = FlashcardProgress::where('user_id', $userId)
            ->selectRaw('SUM(correct_count) as correct, SUM(incorrect_count) as incorrect')
            ->first();

        $total = ($totals->correct ?? 0) + ($totals->incorrect ?? 0);
        
        if ($total === 0) {
            return 0;
        }

        return round(($totals->correct / $total) * 100, 1);
    }

    /**
     * Çalışma streak'i hesapla
     */
    protected function calculateStreak(int $userId): int
    {
        $sessions = StudySession::where('user_id', $userId)
            ->whereNotNull('ended_at')
            ->orderByDesc('ended_at')
            ->get(['ended_at']);

        if ($sessions->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $currentDate = today();

        foreach ($sessions as $session) {
            $sessionDate = $session->ended_at->startOfDay();
            
            if ($sessionDate->equalTo($currentDate) || $sessionDate->equalTo($currentDate->subDay())) {
                $streak++;
                $currentDate = $sessionDate;
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * Bugün tekrarı gereken kart sayısı
     */
    protected function getCardsDueCount(int $userId): int
    {
        return FlashcardProgress::where('user_id', $userId)
            ->where('next_review_at', '<=', now())
            ->count();
    }

    /**
     * Deste oluştur
     */
    public function createDeck(int $userId, array $data): FlashcardDeck
    {
        $data['user_id'] = $userId;
        
        return FlashcardDeck::create($data);
    }

    /**
     * Deste'ye kart ekle
     */
    public function addCard(FlashcardDeck $deck, array $data): Flashcard
    {
        $card = $deck->flashcards()->create($data);
        $deck->increment('card_count');
        
        return $card;
    }

    /**
     * Cache temizle
     */
    public function clearCache(): void
    {
        Cache::forget('flashcards.featured');
    }
}
