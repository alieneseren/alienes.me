<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsPortfolioCache
{
    public static function bootClearsPortfolioCache()
    {
        static::saved(function () {
            Cache::forget('homepage_data');
            Cache::forget('profile_data');
        });

        static::deleted(function () {
            Cache::forget('homepage_data');
            Cache::forget('profile_data');
        });
    }
}
