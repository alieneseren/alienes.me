<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomePageCache
{
    /**
     * Boot the trait to add model event listeners.
     */
    public static function bootClearsHomePageCache()
    {
        // ⚡ Bolt: Clear home page cache when models are saved or deleted to prevent stale data
        static::saved(function ($model) {
            Cache::forget('home_page_data');
        });

        static::deleted(function ($model) {
            Cache::forget('home_page_data');
        });
    }
}
