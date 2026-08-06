<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsLayoutCache
{
    public static function bootClearsLayoutCache()
    {
        static::saved(function () {
            Cache::forget('frontend_layout_data');
        });

        static::deleted(function () {
            Cache::forget('frontend_layout_data');
        });
    }
}
