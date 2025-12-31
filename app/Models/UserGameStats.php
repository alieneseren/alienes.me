<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserGameStats extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'total_plays',
        'highest_score',
        'total_score',
        'total_time_seconds',
        'highest_level',
        'first_played_at',
        'last_played_at',
    ];

    protected $casts = [
        'first_played_at' => 'datetime',
        'last_played_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
