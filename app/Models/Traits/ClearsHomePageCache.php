<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomePageCache
{
    /**
     * Boot the trait.
     *
     * @return void
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
