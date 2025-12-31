<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_points',
        'percentage',
        'passed',
        'time_taken_seconds',
        'answers',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Süre formatı
     */
    public function getFormattedTimeAttribute(): string
    {
        $minutes = floor($this->time_taken_seconds / 60);
        $seconds = $this->time_taken_seconds % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
