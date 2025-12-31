<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'deck_id',
        'front',
        'back',
        'hint',
        'media_front',
        'media_back',
        'tags',
        'order',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function deck(): BelongsTo
    {
        return $this->belongsTo(FlashcardDeck::class, 'deck_id');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(FlashcardProgress::class);
    }

    /**
     * Kullanıcının bu karttaki ilerlemesi
     */
    public function userProgress(int $userId)
    {
        return $this->progress()->where('user_id', $userId)->first();
    }
}
