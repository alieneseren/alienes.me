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
        // Invalidate homepage cache when models are updated/deleted
        $modelsToCache = [
            \App\Models\Profile::class,
            \App\Models\Experience::class,
            \App\Models\Education::class,
            \App\Models\Skill::class,
            \App\Models\Project::class,
        ];

        foreach ($modelsToCache as $model) {
            $model::saved(function () {
                \Illuminate\Support\Facades\Cache::forget('home.data');
            });
            $model::deleted(function () {
                \Illuminate\Support\Facades\Cache::forget('home.data');
            });
        }
    }
}
