<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomePageCache
{
    /**
     * Boot the trait and register model events.
     */
    protected static function bootClearsHomePageCache()
    {
        static::saved(function ($model) {
            self::clearHomePageCache();
        });

        static::deleted(function ($model) {
            self::clearHomePageCache();
        });
    }

    /**
     * Clear the home page cache.
     */
    protected static function clearHomePageCache()
    {
        Cache::forget('home_page_data');
    }
}
