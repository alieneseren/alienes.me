<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \App\Models\Profile::observe(\App\Observers\CacheClearObserver::class);
        \App\Models\Experience::observe(\App\Observers\CacheClearObserver::class);
        \App\Models\Education::observe(\App\Observers\CacheClearObserver::class);
        \App\Models\Skill::observe(\App\Observers\CacheClearObserver::class);
        \App\Models\Project::observe(\App\Observers\CacheClearObserver::class);
        \App\Models\Cv::observe(\App\Observers\CacheClearObserver::class);
    }
}
