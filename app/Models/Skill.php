<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Skill extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget('skills');
        });

        static::deleted(function ($model) {
            Cache::forget('skills');
        });
    }

    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'order',
    ];

    protected $casts = [
        'proficiency' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
