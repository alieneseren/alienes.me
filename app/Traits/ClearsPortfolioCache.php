<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsPortfolioCache
{
    public static function bootClearsPortfolioCache()
    {
        static::saved(function () {
            self::clearPortfolioCache();
        });

        static::deleted(function () {
            self::clearPortfolioCache();
        });
    }

    protected static function clearPortfolioCache()
    {
        Cache::forget('portfolio.home_data');
        Cache::forget('portfolio.profile');
    }
}
