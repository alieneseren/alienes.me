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
        // Cache invalidation for Profile
        Profile::saved(function () {
            Cache::forget('profile.data');
        });
        Profile::deleted(function () {
            Cache::forget('profile.data');
        });

        // Cache invalidation for Home Collections
        $invalidateHomeCollections = function () {
            Cache::forget('home_collections.data');
        };

        Experience::saved($invalidateHomeCollections);
        Experience::deleted($invalidateHomeCollections);

        Education::saved($invalidateHomeCollections);
        Education::deleted($invalidateHomeCollections);

        Skill::saved($invalidateHomeCollections);
        Skill::deleted($invalidateHomeCollections);

        // Cache invalidation for Projects
        $invalidateProjects = function () {
            Cache::forget('home_collections.data');
            // Instead of Cache::flush(), we will clear plausible pages manually to avoid clearing session/rate-limits.
            // A safer approach since file cache lacks tags.
            // In case of more pages, the 1-day TTL will clear them naturally.
            for ($i = 1; $i <= 20; $i++) {
                Cache::forget("projects.page.{$i}");
            }
        };

        Project::saved($invalidateProjects);
        Project::deleted($invalidateProjects);
    }
}
