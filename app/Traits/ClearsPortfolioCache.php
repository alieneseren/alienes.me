<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsPortfolioCache
{
    public static function bootClearsPortfolioCache()
    {
        static::saved(function () {
            Cache::forget('home_page_data');
        });

        static::deleted(function () {
            Cache::forget('home_page_data');
        });
    }
}
