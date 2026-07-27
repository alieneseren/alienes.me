<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsLayoutCache
{
    protected static function bootClearsLayoutCache()
    {
        static::saved(function ($model) {
            Cache::forget('frontend_layout_flags');
        });

        static::deleted(function ($model) {
            Cache::forget('frontend_layout_flags');
        });
    }
}
