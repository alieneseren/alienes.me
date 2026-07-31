<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsFrontendCache
{
    protected static function bootClearsFrontendCache()
    {
        static::saved(function ($model) {
            self::clearFrontendCache();
        });

        static::deleted(function ($model) {
            self::clearFrontendCache();
        });
    }

    protected static function clearFrontendCache()
    {
        Cache::forget('frontend.home_data');
        Cache::forget('frontend.profile');
    }
}
