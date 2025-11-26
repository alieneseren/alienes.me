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
        
        $leaderboards = [];
        foreach ($games as $game) {
            $leaderboards[$game] = GameScore::getTopScores($game, 5);
        }

        return response()->json([
            'success' => true,
            'leaderboards' => $leaderboards
        ]);
    }
}
