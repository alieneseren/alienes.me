<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomePageCache
{
    /**
     * Boot the trait.
     */
    protected static function bootClearsHomePageCache()
    {
        // ⚡ Bolt: Clear homepage and projects page caches when models are saved or deleted to prevent stale data.
        static::saved(function () {
            Cache::forget('home_page_data');
            Cache::forget('projects_page_profile');
        });

        static::deleted(function () {
            Cache::forget('home_page_data');
            Cache::forget('projects_page_profile');
        });
    }
}
