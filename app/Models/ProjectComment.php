<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'guest_name',
        'guest_email',
        'content',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Yazar adını getir
     */
    public function getAuthorNameAttribute(): string
    {
        return $this->user?->name ?? $this->guest_name ?? 'Anonim';
    }
}
