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
        // ⚡ Bolt: Cache invalidation for home page models
        $clearProfileCache = function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        };
        \App\Models\Profile::saved($clearProfileCache);
        \App\Models\Profile::deleted($clearProfileCache);

        $clearHomeCollectionsCache = function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.data');
        };
        \App\Models\Experience::saved($clearHomeCollectionsCache);
        \App\Models\Experience::deleted($clearHomeCollectionsCache);
        \App\Models\Education::saved($clearHomeCollectionsCache);
        \App\Models\Education::deleted($clearHomeCollectionsCache);
        \App\Models\Skill::saved($clearHomeCollectionsCache);
        \App\Models\Skill::deleted($clearHomeCollectionsCache);
        \App\Models\Project::saved($clearHomeCollectionsCache);
        \App\Models\Project::deleted($clearHomeCollectionsCache);
    }
}
