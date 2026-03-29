<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomePageCache
{
    /**
     * Boot the trait and clear cache on save/delete.
     */
    protected static function bootClearsHomePageCache()
    {
        static::saved(function ($model) {
            Cache::forget('home_page_data');
        });

        static::deleted(function ($model) {
            Cache::forget('home_page_data');
        });
    }
}
