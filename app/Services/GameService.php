<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GameScore;
use App\Models\UserGameStats;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Game Service
 * 
 * Oyun işlemleri, skor kaydetme ve leaderboard yönetimi
 */
class GameService
{
    protected const CACHE_TTL = 300; // 5 dakika (leaderboard için daha kısa)
    protected const LEADERBOARD_LIMIT = 100;

    /**
     * Tüm aktif oyunları getir
     */
    public function getGames(bool $featuredOnly = false): Collection
    {
        $cacheKey = $featuredOnly ? 'games.featured' : 'games.all';

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($featuredOnly) {
            $query = Game::query()
                ->where('is_active', true)
                ->orderBy('order');

            if ($featuredOnly) {
                $query->where('is_featured', true);
            }

            return $query->get();
        });
    }

    /**
     * Tek oyun getir (slug ile)
     */
    public function getGameBySlug(string $slug): ?Game
    {
        return Cache::remember("game.{$slug}", self::CACHE_TTL, function () use ($slug) {
            return Game::where('slug', $slug)
                ->where('is_active', true)
                ->first();
        });
    }

    /**
     * Skor kaydet
     */
    public function saveScore(
        Game $game,
        int $score,
        ?int $userId = null,
        ?string $playerName = null,
        array $metadata = []
    ): GameScore {
        // Anti-cheat: Makul olmayan skorları reddet
        if (!$this->validateScore($game, $score, $metadata)) {
            throw new \InvalidArgumentException('Geçersiz skor');
        }

        $gameScore = GameScore::create([
            'game_id' => $game->id,
            'user_id' => $userId,
            'player_name' => $playerName ?? 'Anonim',
            'score' => $score,
            'level' => $metadata['level'] ?? null,
            'time_seconds' => $metadata['time_seconds'] ?? null,
            'metadata' => $metadata,
            'ip_hash' => hash('sha256', request()->ip()),
            'is_verified' => $userId !== null,
        ]);

        // Oyun istatistiklerini güncelle
        $game->increment('play_count');

        // Kullanıcı istatistiklerini güncelle
        if ($userId) {
            $this->updateUserStats($userId, $game, $score, $metadata);
        }

        // Leaderboard cache'ini temizle
        $this->clearLeaderboardCache($game->id);

        return $gameScore;
    }

    /**
     * Leaderboard getir
     */
    public function getLeaderboard(
        Game $game,
        string $period = 'all_time',
        int $limit = 10
    ): Collection {
        $cacheKey = "leaderboard.{$game->id}.{$period}.{$limit}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($game, $period, $limit) {
            $query = GameScore::query()
                ->where('game_id', $game->id)
                ->orderByDesc('score');

            // Dönem filtreleme
            switch ($period) {
                case 'daily':
                    $query->whereDate('created_at', today());
                    break;
                case 'weekly':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'monthly':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }

            return $query->limit($limit)->get();
        });
    }

    /**
     * Kullanıcının oyundaki sıralamasını getir
     */
    public function getUserRank(Game $game, int $userId): ?int
    {
        $userBestScore = GameScore::where('game_id', $game->id)
            ->where('user_id', $userId)
            ->max('score');

        if (!$userBestScore) {
            return null;
        }

        return GameScore::where('game_id', $game->id)
            ->where('score', '>', $userBestScore)
            ->distinct('user_id')
            ->count() + 1;
    }

    /**
     * Kullanıcının tüm oyun istatistiklerini getir
     */
    public function getUserGameStats(int $userId, ?Game $game = null): Collection
    {
        $query = UserGameStats::query()
            ->with('game')
            ->where('user_id', $userId);

        if ($game) {
            $query->where('game_id', $game->id);
        }

        return $query->get();
    }

    /**
     * Global oyun istatistikleri
     */
    public function getGlobalStats(): array
    {
        return Cache::remember('games.global_stats', self::CACHE_TTL, function () {
            return [
                'total_games' => Game::where('is_active', true)->count(),
                'total_plays' => Game::sum('play_count'),
                'total_scores' => GameScore::count(),
                'unique_players' => GameScore::distinct('user_id')->whereNotNull('user_id')->count(),
                'top_game' => Game::orderByDesc('play_count')->first()?->name,
            ];
        });
    }

    /**
     * Günlük snapshot oluştur (cron job için)
     */
    public function createDailySnapshot(): void
    {
        $games = Game::where('has_leaderboard', true)->get();

        foreach ($games as $game) {
            $rankings = $this->getLeaderboard($game, 'daily', self::LEADERBOARD_LIMIT);

            DB::table('leaderboard_snapshots')->insert([
                'game_id' => $game->id,
                'period' => 'daily',
                'period_start' => today(),
                'period_end' => today(),
                'rankings' => json_encode($rankings->toArray()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Skor validasyonu (anti-cheat)
     */
    protected function validateScore(Game $game, int $score, array $metadata): bool
    {
        // Negatif skor kabul edilmez
        if ($score < 0) {
            return false;
        }

        // Oyun spesifik maksimum skor kontrolü
        $config = $game->config ?? [];
        $maxScore = $config['max_possible_score'] ?? PHP_INT_MAX;
        
        if ($score > $maxScore) {
            return false;
        }

        // Süre bazlı oyunlarda mantıksız süre kontrolü
        if (isset($metadata['time_seconds']) && $metadata['time_seconds'] < 0) {
            return false;
        }

        return true;
    }

    /**
     * Kullanıcı istatistiklerini güncelle
     */
    protected function updateUserStats(int $userId, Game $game, int $score, array $metadata): void
    {
        $stats = UserGameStats::firstOrNew([
            'user_id' => $userId,
            'game_id' => $game->id,
        ]);

        $stats->total_plays++;
        $stats->total_score += $score;
        
        if ($score > $stats->highest_score) {
            $stats->highest_score = $score;
        }

        if (isset($metadata['level']) && $metadata['level'] > $stats->highest_level) {
            $stats->highest_level = $metadata['level'];
        }

        if (isset($metadata['time_seconds'])) {
            $stats->total_time_seconds += $metadata['time_seconds'];
        }

        $stats->first_played_at = $stats->first_played_at ?? now();
        $stats->last_played_at = now();

        $stats->save();
    }

    /**
     * Leaderboard cache temizle
     */
    protected function clearLeaderboardCache(int $gameId): void
    {
        foreach (['all_time', 'daily', 'weekly', 'monthly'] as $period) {
            for ($limit = 10; $limit <= 100; $limit += 10) {
                Cache::forget("leaderboard.{$gameId}.{$period}.{$limit}");
            }
        }
    }

    /**
     * Tüm oyun cache'ini temizle
     */
    public function clearCache(): void
    {
        Cache::forget('games.all');
        Cache::forget('games.featured');
        Cache::forget('games.global_stats');
    }
}
