<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomepageCache
{
    protected static function bootClearsHomepageCache()
    {
        static::saved(function ($model) {
            Cache::forget('homepage_data');
        });

        static::deleted(function ($model) {
            Cache::forget('homepage_data');
        });
    }
}
