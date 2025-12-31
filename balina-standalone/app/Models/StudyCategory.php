<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function notes()
    {
        return $this->hasMany(StudyNote::class, 'category_id');
    }

    public function activeNotes()
    {
        return $this->hasMany(StudyNote::class, 'category_id')
                    ->where('is_active', true)
                    ->orderBy('order');
    }
}
