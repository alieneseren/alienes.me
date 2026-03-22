<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Education extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget('educations');
        });

        static::deleted(function ($model) {
            Cache::forget('educations');
        });
    }

    protected $table = 'educations';

    protected $fillable = [
        'school',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'gpa',
        'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'gpa' => 'decimal:2',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('start_date', 'desc');
    }
}
