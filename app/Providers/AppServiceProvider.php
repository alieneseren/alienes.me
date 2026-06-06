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
        $clearProfileCache = function () {
            Cache::forget('profile.data');
        };

        Profile::saved($clearProfileCache);
        Profile::deleted($clearProfileCache);

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
