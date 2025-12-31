<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'long_description',
        'thumbnail',
        'difficulty',
        'estimated_hours',
        'order',
        'is_published',
        'is_featured',
        'view_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Kurs modülleri
     */
    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class);
    }

    /**
     * Kullanıcı ilerlemeleri
     */
    public function progress(): HasMany
    {
        return $this->hasMany(CourseProgress::class);
    }

    /**
     * Flashcard desteleri
     */
    public function flashcardDecks(): HasMany
    {
        return $this->hasMany(FlashcardDeck::class);
    }

    /**
     * Toplam modül sayısı
     */
    public function getModuleCountAttribute(): int
    {
        return $this->modules()->count();
    }

    /**
     * Zorluk badge rengi
     */
    public function getDifficultyColorAttribute(): string
    {
        return match($this->difficulty) {
            'beginner' => 'green',
            'intermediate' => 'yellow',
            'advanced' => 'red',
            default => 'gray',
        };
    }
}
