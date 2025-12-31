<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deck_id',
        'cards_studied',
        'correct_answers',
        'incorrect_answers',
        'duration_seconds',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deck(): BelongsTo
    {
        return $this->belongsTo(FlashcardDeck::class, 'deck_id');
    }

    /**
     * Doğruluk oranı
     */
    public function getAccuracyAttribute(): float
    {
        if ($this->cards_studied === 0) {
            return 0;
        }

        return round(($this->correct_answers / $this->cards_studied) * 100, 1);
    }

    /**
     * Süre formatı
     */
    public function getFormattedDurationAttribute(): string
    {
        $minutes = floor($this->duration_seconds / 60);
        $seconds = $this->duration_seconds % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
