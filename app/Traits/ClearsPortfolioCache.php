<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsPortfolioCache
{
    public static function bootClearsPortfolioCache()
    {
        static::saved(function () {
            Cache::forget('portfolio_home_data');
        });

        static::deleted(function () {
            Cache::forget('portfolio_home_data');
        });
    }
}
