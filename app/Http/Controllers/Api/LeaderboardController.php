<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GameService;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Leaderboard API Controller
 * 
 * Oyun skorları ve liderlik tablosu için REST API
 */
class LeaderboardController extends Controller
{
    public function __construct(
        protected GameService $gameService
    ) {}

    /**
     * Tüm oyunları listele
     * 
     * GET /api/games
     */
    public function games(): JsonResponse
    {
        $games = $this->gameService->getGames();

        return response()->json([
            'success' => true,
            'data' => $games->map(fn ($game) => [
                'id' => $game->id,
                'name' => $game->name,
                'slug' => $game->slug,
                'description' => $game->description,
                'thumbnail' => $game->thumbnail,
                'has_leaderboard' => $game->has_leaderboard,
                'play_count' => $game->play_count,
            ]),
        ]);
    }

    /**
     * Oyun leaderboard'ı
     * 
     * GET /api/games/{slug}/leaderboard
     */
    public function leaderboard(string $slug, Request $request): JsonResponse
    {
        $game = $this->gameService->getGameBySlug($slug);

        if (!$game) {
            return response()->json([
                'success' => false,
                'message' => 'Oyun bulunamadı',
            ], 404);
        }

        $period = $request->get('period', 'all_time');
        $limit = min((int) $request->get('limit', 10), 100);

        $leaderboard = $this->gameService->getLeaderboard($game, $period, $limit);

        return response()->json([
            'success' => true,
            'data' => [
                'game' => [
                    'name' => $game->name,
                    'slug' => $game->slug,
                ],
                'period' => $period,
                'rankings' => $leaderboard->map(fn ($score, $index) => [
                    'rank' => $index + 1,
                    'player_name' => $score->display_name,
                    'score' => $score->score,
                    'level' => $score->level,
                    'time_seconds' => $score->time_seconds,
                    'is_verified' => $score->is_verified,
                    'created_at' => $score->created_at->toIso8601String(),
                ]),
            ],
        ]);
    }

    /**
     * Skor gönder
     * 
     * POST /api/games/{slug}/score
     */
    public function submitScore(string $slug, Request $request): JsonResponse
    {
        $game = $this->gameService->getGameBySlug($slug);

        if (!$game) {
            return response()->json([
                'success' => false,
                'message' => 'Oyun bulunamadı',
            ], 404);
        }

        $validated = $request->validate([
            'score' => 'required|integer|min:0',
            'player_name' => 'nullable|string|max:50',
            'level' => 'nullable|integer|min:0',
            'time_seconds' => 'nullable|integer|min:0',
            'metadata' => 'nullable|array',
        ]);

        try {
            $gameScore = $this->gameService->saveScore(
                $game,
                $validated['score'],
                auth()->id(),
                $validated['player_name'] ?? null,
                array_filter([
                    'level' => $validated['level'] ?? null,
                    'time_seconds' => $validated['time_seconds'] ?? null,
                    ...$validated['metadata'] ?? [],
                ])
            );

            // Sıralama hesapla
            $rank = auth()->check() 
                ? $this->gameService->getUserRank($game, auth()->id())
                : null;

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $gameScore->id,
                    'score' => $gameScore->score,
                    'rank' => $rank,
                    'is_new_high_score' => $rank === 1,
                ],
            ], 201);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Kullanıcının oyun istatistikleri
     * 
     * GET /api/games/{slug}/my-stats
     */
    public function myStats(string $slug): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Giriş yapmalısınız',
            ], 401);
        }

        $game = $this->gameService->getGameBySlug($slug);

        if (!$game) {
            return response()->json([
                'success' => false,
                'message' => 'Oyun bulunamadı',
            ], 404);
        }

        $stats = $this->gameService->getUserGameStats(auth()->id(), $game)->first();
        $rank = $this->gameService->getUserRank($game, auth()->id());

        return response()->json([
            'success' => true,
            'data' => [
                'rank' => $rank,
                'total_plays' => $stats?->total_plays ?? 0,
                'highest_score' => $stats?->highest_score ?? 0,
                'total_score' => $stats?->total_score ?? 0,
                'highest_level' => $stats?->highest_level ?? 0,
                'total_time_seconds' => $stats?->total_time_seconds ?? 0,
                'first_played_at' => $stats?->first_played_at?->toIso8601String(),
                'last_played_at' => $stats?->last_played_at?->toIso8601String(),
            ],
        ]);
    }

    /**
     * Global istatistikler
     * 
     * GET /api/stats
     */
    public function globalStats(): JsonResponse
    {
        $stats = $this->gameService->getGlobalStats();

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
