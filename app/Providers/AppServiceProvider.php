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
        \App\Models\Profile::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });
        \App\Models\Profile::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        });

        \App\Models\Experience::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.experiences');
        });
        \App\Models\Experience::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.experiences');
        });

        \App\Models\Education::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.educations');
        });
        \App\Models\Education::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.educations');
        });

        \App\Models\Skill::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.skills');
        });
        \App\Models\Skill::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.skills');
        });

        \App\Models\Project::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.featured_projects');
        });
        \App\Models\Project::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.featured_projects');
        });
    }
}
