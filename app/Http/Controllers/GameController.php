<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{
    public function saveScore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50',
            'game_name' => 'required|string|max:50',
            'score' => 'required|integer|min:0',
            'level' => 'nullable|integer',
            'time' => 'nullable|integer',
            'extra_data' => 'nullable|array'
        ]);

        $validated['ip_address'] = $request->ip();

        $gameScore = GameScore::create($validated);

        // Skoru ekledikten sonra cache'leri temizliyoruz ki en güncel skorlar görünebilsin
        Cache::forget("leaderboard_{$validated['game_name']}_10");
        Cache::forget("leaderboard_{$validated['game_name']}_5");
        Cache::forget("all_leaderboards");

        return response()->json([
            'success' => true,
            'message' => 'Skor kaydedildi!',
            'data' => $gameScore,
            'leaderboard' => GameScore::getTopScores($validated['game_name'], 10)
        ]);
    }

    public function getLeaderboard(Request $request, $gameName)
    {
        $limit = $request->input('limit', 10);

        // ⚡ Bolt: Oyuna özel skor sıralamasını limit bazlı önbellekliyoruz
        $cacheKey = "leaderboard_{$gameName}_{$limit}";
        $scores = Cache::remember($cacheKey, 60, function () use ($gameName, $limit) {
            return GameScore::getTopScores($gameName, $limit);
        });

        return response()->json([
            'success' => true,
            'game' => $gameName,
            'scores' => $scores
        ]);
    }

    public function getUserScore(Request $request, $gameName, $username)
    {
        $score = GameScore::getUserBestScore($username, $gameName);

        return response()->json([
            'success' => true,
            'score' => $score
        ]);
    }

    public function getAllLeaderboards()
    {
        // ⚡ Bolt: Liderlik tablosu her oyun için sorgulandığında 10 sorgu atıyordu.
        // Bunu cacheleyerek performansı artırıyoruz ve veritabanı yükünü düşürüyoruz.
        $leaderboards = Cache::remember('all_leaderboards', 60, function () {
            $games = ['2048', 'snake', 'flappy-bird', 'memory-card', 'tic-tac-toe',
                      'quiz', 'breakout', 'color-matcher', 'typing-speed', 'math-quiz'];

            $results = [];
            foreach ($games as $game) {
                // TopScores zaten sıralamayı getiriyor
                $results[$game] = GameScore::getTopScores($game, 5);
            }
            return $results;
        });

        return response()->json([
            'success' => true,
            'leaderboards' => $leaderboards
        ]);
    }
}
