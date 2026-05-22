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
        // Invalidate homepage cache when portfolio models change
        $clearHomeCache = function () {
            Cache::forget('home.data');
        };

        $models = [
            Profile::class,
            Experience::class,
            Education::class,
            Skill::class,
            Project::class,
        ];

        foreach ($models as $model) {
            $model::saved($clearHomeCache);
            $model::deleted($clearHomeCache);
        }
    }
}
