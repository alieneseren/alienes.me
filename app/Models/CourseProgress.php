<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseProgress extends Model
{
    use HasFactory;

    protected $table = 'course_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'current_module_id',
        'completed_modules',
        'total_modules',
        'progress_percentage',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function currentModule(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'current_module_id');
    }

    /**
     * Tamamlandı mı?
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->completed_at !== null;
    }
}
