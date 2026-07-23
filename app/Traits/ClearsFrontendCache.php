<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsFrontendCache
{
    public static function bootClearsFrontendCache()
    {
        static::saved(function () {
            Cache::forget('frontend_layout_data');
        });

        static::deleted(function () {
            Cache::forget('frontend_layout_data');
        });
    }
}
