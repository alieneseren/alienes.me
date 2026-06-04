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
        // ⚡ Bolt Optimization: Clear profile cache on updates or deletions
        \App\Models\Profile::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });

        \App\Models\Profile::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });

        // ⚡ Bolt Optimization: Clear grouped home collections cache on related model updates
        $clearHomeCollections = function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.data');
        };

        \App\Models\Experience::saved($clearHomeCollections);
        \App\Models\Experience::deleted($clearHomeCollections);

        \App\Models\Education::saved($clearHomeCollections);
        \App\Models\Education::deleted($clearHomeCollections);

        \App\Models\Skill::saved($clearHomeCollections);
        \App\Models\Skill::deleted($clearHomeCollections);

        \App\Models\Project::saved($clearHomeCollections);
        \App\Models\Project::deleted($clearHomeCollections);
    }
}
