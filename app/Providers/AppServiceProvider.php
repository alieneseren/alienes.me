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
        // Cache invalidation for Profile
        \App\Models\Profile::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });
        \App\Models\Profile::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });

        // Cache invalidation for Home Collections
        $collectionModels = [
            \App\Models\Experience::class,
            \App\Models\Education::class,
            \App\Models\Skill::class,
            \App\Models\Project::class,
        ];

        foreach ($collectionModels as $model) {
            $model::saved(function () {
                \Illuminate\Support\Facades\Cache::forget('home_collections.data');
            });
            $model::deleted(function () {
                \Illuminate\Support\Facades\Cache::forget('home_collections.data');
            });
        }
    }
}
