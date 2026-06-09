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
        // Profile cache invalidation
        \App\Models\Profile::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });
        \App\Models\Profile::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });

        // Home collections cache invalidation
        $clearHomeCache = function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.data');
        };

        \App\Models\Experience::saved($clearHomeCache);
        \App\Models\Experience::deleted($clearHomeCache);

        \App\Models\Education::saved($clearHomeCache);
        \App\Models\Education::deleted($clearHomeCache);

        \App\Models\Skill::saved($clearHomeCache);
        \App\Models\Skill::deleted($clearHomeCache);

        \App\Models\Project::saved($clearHomeCache);
        \App\Models\Project::deleted($clearHomeCache);
    }
}
