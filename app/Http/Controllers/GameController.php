<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;

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
        $scores = GameScore::getTopScores($gameName, $limit);

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
        $games = ['2048', 'snake', 'flappy-bird', 'memory-card', 'tic-tac-toe', 
                  'quiz', 'breakout', 'color-matcher', 'typing-speed', 'math-quiz'];
        
        // ⚡ Bolt Optimizasyonu: N+1 Sorgu Problemini Çözme
        // Daha önce her oyun için ayrı bir veritabanı sorgusu yapılıyordu (10 sorgu).
        // Şimdi ROW_NUMBER() window fonksiyonu kullanılarak tek bir sorguda
        // tüm oyunların ilk 5 skoru getiriliyor.
        $topScores = GameScore::fromSub(
            GameScore::selectRaw('*, ROW_NUMBER() OVER(PARTITION BY game_name ORDER BY score DESC, created_at ASC) as rn')
                     ->whereIn('game_name', $games),
            'sub'
        )->where('rn', '<=', 5)->get();

        $groupedScores = $topScores->groupBy('game_name');

        $leaderboards = [];
        foreach ($games as $game) {
            $scores = $groupedScores->get($game, collect())->values();
            // Eski yapıya tam uyması için 'rn' alanını gizliyoruz
            $scores->each->makeHidden(['rn']);
            $leaderboards[$game] = $scores;
        }

        return response()->json([
            'success' => true,
            'leaderboards' => $leaderboards
        ]);
    }
}
