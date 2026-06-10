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
        // ⚡ Bolt: Cache invalidation for homepage data
        $clearProfileCache = function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        };

        $clearCollectionsCache = function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.data');
        };

        \App\Models\Profile::saved($clearProfileCache);
        \App\Models\Profile::deleted($clearProfileCache);

        $collectionModels = [
            \App\Models\Experience::class,
            \App\Models\Education::class,
            \App\Models\Skill::class,
            \App\Models\Project::class,
        ];

        foreach ($collectionModels as $model) {
            $model::saved($clearCollectionsCache);
            $model::deleted($clearCollectionsCache);
        }
    }
}
