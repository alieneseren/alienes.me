<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsPortfolioCache
{
    public static function bootClearsPortfolioCache()
    {
        static::saved(function ($model) {
            Cache::forget('home_page_data');
        });

        static::deleted(function ($model) {
            Cache::forget('home_page_data');
        });
    }
}
