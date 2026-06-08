<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Cache invalidation for homepage models
        $clearHomeCache = function () {
            Cache::forget('profile.data');
            Cache::forget('home_collections.data');
        };

        Profile::saved($clearHomeCache);
        Profile::deleted($clearHomeCache);

        Experience::saved($clearHomeCache);
        Experience::deleted($clearHomeCache);

        Education::saved($clearHomeCache);
        Education::deleted($clearHomeCache);

        Skill::saved($clearHomeCache);
        Skill::deleted($clearHomeCache);

        $clearProjectCache = function () {
            Cache::forget('profile.data');
            Cache::forget('home_collections.data');

            // Clear paginated project cache
            // Since we can't use tags, a simplistic approach is to clear a reasonable range of pages
            // In a real production app without Redis, a better custom cache invalidation for paginated results
            // might be needed, or using a package that supports tag-like features on file cache.
            // For now, clearing the first 50 pages should cover most updates
            for ($i = 1; $i <= 50; $i++) {
                Cache::forget('projects.page.' . $i);
            }
        };

        Project::saved($clearProjectCache);
        Project::deleted($clearProjectCache);
    }
}
