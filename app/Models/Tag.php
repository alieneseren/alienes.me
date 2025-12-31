<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Tag'e ait yazılar
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'blog_post_tag', 'tag_id', 'blog_post_id');
    }

    /**
     * Otomatik slug oluştur
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }
}
