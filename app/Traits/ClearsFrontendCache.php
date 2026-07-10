<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsFrontendCache
{
    protected static function bootClearsFrontendCache()
    {
        static::saved(function ($model) {
            Cache::forget('frontend_homepage_data');
            Cache::forget('frontend_profile_data');
        });

        static::deleted(function ($model) {
            Cache::forget('frontend_homepage_data');
            Cache::forget('frontend_profile_data');
        });
    }
}
