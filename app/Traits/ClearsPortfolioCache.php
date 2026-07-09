<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsPortfolioCache
{
    protected static function bootClearsPortfolioCache()
    {
        static::saved(function () {
            static::clearPortfolioCache();
        });

        static::deleted(function () {
            static::clearPortfolioCache();
        });
    }

    /**
     * Clear cached portfolio data on model change.
     * Performance Optimization: Invalidate the combined homepage and profile
     * cache blocks to ensure frontend always displays fresh data.
     */
    protected static function clearPortfolioCache()
    {
        Cache::forget('home_page_data');
        Cache::forget('portfolio_profile');
    }
}
