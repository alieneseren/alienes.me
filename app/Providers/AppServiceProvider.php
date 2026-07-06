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
        // ⚡ Bolt: Invalidate homepage cache on model changes
        Profile::saved(function () {
            Cache::forget('home_profile');
        });
        Profile::deleted(function () {
            Cache::forget('home_profile');
        });

        Experience::saved(function () {
            Cache::forget('home_experiences');
        });
        Experience::deleted(function () {
            Cache::forget('home_experiences');
        });

        Education::saved(function () {
            Cache::forget('home_educations');
        });
        Education::deleted(function () {
            Cache::forget('home_educations');
        });

        Skill::saved(function () {
            Cache::forget('home_skills');
        });
        Skill::deleted(function () {
            Cache::forget('home_skills');
        });

        Project::saved(function () {
            Cache::forget('home_featured_projects');
        });
        Project::deleted(function () {
            Cache::forget('home_featured_projects');
        });
    }
}
