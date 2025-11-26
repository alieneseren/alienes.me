<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'email',
        'phone',
        'address',
        'summary',
        'education',
        'experience',
        'skills',
        'languages',
        'social_links',
        'is_published'
    ];

    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'skills' => 'array',
        'languages' => 'array',
        'social_links' => 'array',
        'is_published' => 'boolean'
    ];
}
