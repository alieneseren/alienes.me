<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_module_id',
        'title',
        'description',
        'time_limit_minutes',
        'passing_score',
        'shuffle_questions',
        'show_correct_answers',
    ];

    protected $casts = [
        'shuffle_questions' => 'boolean',
        'show_correct_answers' => 'boolean',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Soru sayısı
     */
    public function getQuestionCountAttribute(): int
    {
        return $this->questions()->count();
    }
}
