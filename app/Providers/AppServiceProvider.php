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
        $clearHomeCache = function () {
            Cache::forget('home.data');
        };

        // ⚡ Bolt: Clear home page cache when any associated model is created, updated, or deleted.
        Profile::saved($clearHomeCache);
        Profile::deleted($clearHomeCache);

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
