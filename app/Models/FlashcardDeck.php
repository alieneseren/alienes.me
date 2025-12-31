<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FlashcardDeck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'category',
        'card_count',
        'is_public',
        'is_featured',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function flashcards(): HasMany
    {
        return $this->hasMany(Flashcard::class, 'deck_id');
    }

    public function studySessions(): HasMany
    {
        return $this->hasMany(StudySession::class, 'deck_id');
    }

    /**
     * Sistem destesi mi?
     */
    public function getIsSystemDeckAttribute(): bool
    {
        return $this->user_id === null;
    }
}
