<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'points',
        'type',
        'rarity',
        'requirements',
        'game_id',
    ];

    protected $casts = [
        'requirements' => 'array',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function userAchievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }

    /**
     * Kaç kullanıcı kazanmış
     */
    public function getUnlockedCountAttribute(): int
    {
        return $this->userAchievements()->where('is_completed', true)->count();
    }

    /**
     * Rarity rengi
     */
    public function getRarityColorAttribute(): string
    {
        return match($this->rarity) {
            'common' => 'gray',
            'uncommon' => 'green',
            'rare' => 'blue',
            'epic' => 'purple',
            'legendary' => 'yellow',
            default => 'gray',
        };
    }
}
