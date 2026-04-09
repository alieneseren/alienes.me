<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomePageCache
{
    /**
     * Boot the trait and register model events to clear the cache.
     *
     * @return void
     */
    protected static function bootClearsHomePageCache()
    {
        static::saved(function () {
            Cache::forget('home_page_data');
        });

        static::deleted(function () {
            Cache::forget('home_page_data');
        });
    }
}
