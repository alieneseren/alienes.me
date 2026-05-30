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
        $models = [
            \App\Models\Profile::class,
            \App\Models\Experience::class,
            \App\Models\Education::class,
            \App\Models\Skill::class,
            \App\Models\Project::class,
        ];

        foreach ($models as $model) {
            $model::saved(function () {
                \Illuminate\Support\Facades\Cache::forget('home.data');
            });

            $model::deleted(function () {
                \Illuminate\Support\Facades\Cache::forget('home.data');
            });
        }
    }
}
