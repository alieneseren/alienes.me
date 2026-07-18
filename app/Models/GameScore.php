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

    public static function getAllTopScores(array $games, $limit = 5)
    {
        $subQuery = self::whereIn('game_name', $games)
            ->selectRaw('*, ROW_NUMBER() OVER(PARTITION BY game_name ORDER BY score DESC, created_at ASC) as rn');

        $topScores = self::fromSub($subQuery, (new self)->getTable())
            ->where('rn', '<=', $limit)
            ->orderBy('score', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        $leaderboards = [];
        foreach ($games as $game) {
            $leaderboards[$game] = collect([]);
        }

        foreach ($topScores as $score) {
            unset($score->rn);
            $leaderboards[$score->game_name]->push($score);
        }

        return collect($leaderboards);
    }
}
