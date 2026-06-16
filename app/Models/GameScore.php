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

    protected static function booted()
    {
        $clearCache = function ($score) {
            // Sadece kullanılan yaygın limitleri temizle (örneğin 5 ve 10)
            \Illuminate\Support\Facades\Cache::forget("game_scores_top_{$score->game_name}_5");
            \Illuminate\Support\Facades\Cache::forget("game_scores_top_{$score->game_name}_10");
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }

    public static function getTopScores($gameName, $limit = 10)
    {
        $cacheKey = "game_scores_top_{$gameName}_{$limit}";

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addMinutes(10), function () use ($gameName, $limit) {
            return self::where('game_name', $gameName)
                ->orderBy('score', 'desc')
                ->orderBy('created_at', 'asc')
                ->limit($limit)
                ->get();
        });
    }

    public static function getUserBestScore($username, $gameName)
    {
        return self::where('username', $username)
            ->where('game_name', $gameName)
            ->orderBy('score', 'desc')
            ->first();
    }
}
