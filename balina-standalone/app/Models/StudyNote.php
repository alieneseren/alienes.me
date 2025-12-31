<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'file_path',
        'type',
        'order',
        'is_active',
        'views'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(StudyCategory::class, 'category_id');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
