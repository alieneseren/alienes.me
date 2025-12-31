<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashcardProgress extends Model
{
    use HasFactory;

    protected $table = 'flashcard_progress';

    protected $fillable = [
        'user_id',
        'flashcard_id',
        'easiness_factor',
        'interval',
        'repetitions',
        'correct_count',
        'incorrect_count',
        'last_reviewed_at',
        'next_review_at',
    ];

    protected $casts = [
        'easiness_factor' => 'float',
        'last_reviewed_at' => 'datetime',
        'next_review_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function flashcard(): BelongsTo
    {
        return $this->belongsTo(Flashcard::class);
    }

    /**
     * Doğruluk oranı
     */
    public function getAccuracyAttribute(): float
    {
        $total = $this->correct_count + $this->incorrect_count;
        
        if ($total === 0) {
            return 0;
        }

        return round(($this->correct_count / $total) * 100, 1);
    }

    /**
     * Tekrar zamanı geldi mi?
     */
    public function getIsDueAttribute(): bool
    {
        return $this->next_review_at === null || $this->next_review_at <= now();
    }
}
