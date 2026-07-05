<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Project;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ⚡ BOLT OPTIMIZATION: Cache invalidation logic
        // This ensures the cached data is automatically cleared whenever the
        // relevant models are created, updated, or deleted, avoiding stale data on the homepage.
        Profile::saved(function () {
            Cache::forget('homepage_profile');
        });
        Profile::deleted(function () {
            Cache::forget('homepage_profile');
        });

        Experience::saved(function () {
            Cache::forget('homepage_experiences');
        });
        Experience::deleted(function () {
            Cache::forget('homepage_experiences');
        });

        Education::saved(function () {
            Cache::forget('homepage_educations');
        });
        Education::deleted(function () {
            Cache::forget('homepage_educations');
        });

        Skill::saved(function () {
            Cache::forget('homepage_skills');
        });
        Skill::deleted(function () {
            Cache::forget('homepage_skills');
        });

        Project::saved(function () {
            Cache::forget('homepage_featured_projects');
        });
        Project::deleted(function () {
            Cache::forget('homepage_featured_projects');
        });
    }
}
