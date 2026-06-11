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
        // ⚡ Bolt: Clear profile cache when updated
        Profile::saved(function () {
            Cache::forget('profile.data');
        });
        Profile::deleted(function () {
            Cache::forget('profile.data');
        });

        // ⚡ Bolt: Clear home collections cache when related models are updated/deleted
        $clearHomeCollectionsCache = function () {
            Cache::forget('home_collections.data');
        };

        Experience::saved($clearHomeCollectionsCache);
        Experience::deleted($clearHomeCollectionsCache);

        Education::saved($clearHomeCollectionsCache);
        Education::deleted($clearHomeCollectionsCache);

        Skill::saved($clearHomeCollectionsCache);
        Skill::deleted($clearHomeCollectionsCache);

        Project::saved($clearHomeCollectionsCache);
        Project::deleted($clearHomeCollectionsCache);
    }
}
