<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'game_name',
        'score',
        'level',
        'time',
        'extra_data',
        'ip_address'
    ];

    protected $casts = [
        'extra_data' => 'array',
        'score' => 'integer',
        'level' => 'integer',
        'time' => 'integer'
    ];

    public static function getTopScores($gameName, $limit = 10)
    {
        return self::where('game_name', $gameName)
            ->orderBy('score', 'desc')
            ->orderBy('created_at', 'asc')
            ->limit($limit)
            ->get();
    }

    public static function getUserBestScore($username, $gameName)
    {
        return self::where('username', $username)
            ->where('game_name', $gameName)
            ->orderBy('score', 'desc')
            ->first();
    }

    public static function getTopScoresForAllGames(array $games, $limit = 5)
    {
        return self::fromSub(function ($query) use ($games) {
            $query->from('game_scores')
                  ->whereIn('game_name', $games)
                  ->selectRaw('*, ROW_NUMBER() OVER(PARTITION BY game_name ORDER BY score DESC, created_at ASC) as row_num');
        }, 'ranked_scores')
        ->where('row_num', '<=', $limit)
        ->get()
        ->groupBy('game_name');
    }
}
