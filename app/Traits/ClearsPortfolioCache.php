<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsPortfolioCache
{
    public static function bootClearsPortfolioCache()
    {
        static::saved(function () {
            Cache::forget('home_page_data');
            Cache::forget('projects_page_profile');
            Cache::forget('contact_page_profile');
        });

        static::deleted(function () {
            Cache::forget('home_page_data');
            Cache::forget('projects_page_profile');
            Cache::forget('contact_page_profile');
        });
    }
}
