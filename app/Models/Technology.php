<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color',
        'category',
        'website_url',
        'proficiency',
    ];

    /**
     * Bu teknolojiyi kullanan projeler
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_technology');
    }
}
