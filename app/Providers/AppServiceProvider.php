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
        // Cache Invalidation for Home Collections
        $homeModels = [
            \App\Models\Experience::class,
            \App\Models\Education::class,
            \App\Models\Skill::class,
            \App\Models\Project::class,
        ];

        foreach ($homeModels as $model) {
            $model::saved(function () {
                \Illuminate\Support\Facades\Cache::forget('home_collections.data');
            });

            $model::deleted(function () {
                \Illuminate\Support\Facades\Cache::forget('home_collections.data');
            });
        }

        // Cache Invalidation for Profile
        \App\Models\Profile::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });

        \App\Models\Profile::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });
    }
}
