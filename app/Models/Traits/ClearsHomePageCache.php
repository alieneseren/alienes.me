<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsHomePageCache
{
    protected static function bootClearsHomePageCache()
    {
        static::saved(function () {
            self::clearHomePageCache();
        });

        static::deleted(function () {
            self::clearHomePageCache();
        });
    }

    protected static function clearHomePageCache()
    {
        Cache::forget('home_page_data');
    }
}
