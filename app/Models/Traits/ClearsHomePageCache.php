<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomePageCache
{
    public static function bootClearsHomePageCache()
    {
        static::saved(function ($model) {
            self::clearRelevantCache($model);
        });

        static::deleted(function ($model) {
            self::clearRelevantCache($model);
        });
    }

    protected static function clearRelevantCache($model)
    {
        Cache::forget('home_page_data');

        // Only clear project cache if the model is Project or Profile
        if ($model instanceof \App\Models\Project || $model instanceof \App\Models\Profile) {
            // Count total projects to know how many pages might exist (12 per page)
            $totalProjects = \App\Models\Project::count();
            $totalPages = ceil($totalProjects / 12);

            // Plus 1 just in case
            for ($i = 1; $i <= $totalPages + 1; $i++) {
                Cache::forget('projects_page_data_' . $i);
            }
        }
    }
}
