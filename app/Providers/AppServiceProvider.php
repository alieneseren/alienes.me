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
        // ⚡ Bolt: Clear profile cache when profile is created, updated or deleted
        Profile::saved(function () {
            Cache::forget('profile.data');
        });
        Profile::deleted(function () {
            Cache::forget('profile.data');
        });

        // ⚡ Bolt: Clear homepage collections cache when related models are modified
        $clearHomeCache = function () {
            Cache::forget('home_collections.data');
        };

        Experience::saved($clearHomeCache);
        Experience::deleted($clearHomeCache);

        Education::saved($clearHomeCache);
        Education::deleted($clearHomeCache);

        Skill::saved($clearHomeCache);
        Skill::deleted($clearHomeCache);

        Project::saved($clearHomeCache);
        Project::deleted($clearHomeCache);
    }
}
