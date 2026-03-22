<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Project extends Model
{
    use HasFactory;

    protected static function booted()
    {
        $clearProjectCaches = function () {
            Cache::forget('featured_projects');

            // Eğer etiket destekleniyorsa (Redis vb)
            if (Cache::getStore() instanceof \Illuminate\Cache\TaggableStore) {
                Cache::tags(['projects'])->flush();
            } else {
                // Sadece file kullanılıyorsa, bilinen 100 sayfaya kadar olan sayfaları manuel temizleyebiliriz
                // Yada daha kolayı cache'i tamamen temizlemektir ama sadece projeleri sileceğiz.
                for ($i = 1; $i <= 50; $i++) {
                    Cache::forget('projects_page_' . $i);
                }
            }
        };

        static::saved(function ($model) use ($clearProjectCaches) {
            $clearProjectCaches();
        });

        static::deleted(function ($model) use ($clearProjectCaches) {
            $clearProjectCaches();
        });
    }

    protected $fillable = [
        'title',
        'description',
        'technologies',
        'image',
        'demo_url',
        'github_url',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_featured' => 'boolean',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
