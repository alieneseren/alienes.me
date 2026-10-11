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
        
        // ⚡ Bolt N+1 Optimizasyonu: SQL window function kullanarak tüm oyunların top 5 skorunu tek sorguda çektik
        $subquery = GameScore::selectRaw('*, ROW_NUMBER() OVER(PARTITION BY game_name ORDER BY score DESC, created_at ASC) as row_num')
            ->whereIn('game_name', $games);

        $topScores = GameScore::fromSub($subquery, (new GameScore)->getTable())
            ->where('row_num', '<=', 5)
            ->get()
            ->groupBy('game_name');

        $leaderboards = [];
        foreach ($games as $game) {
            $gameScores = $topScores->get($game, collect());

            // Formatın bozulmaması için geçici row_num attribute'unu temizliyoruz
            $gameScores->transform(function ($item) {
                unset($item->row_num);
                return $item;
            });

            $leaderboards[$game] = $gameScores;
        }

        return response()->json([
            'success' => true,
            'leaderboards' => $leaderboards
        ]);
    }
}
