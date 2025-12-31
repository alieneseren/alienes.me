<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

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
