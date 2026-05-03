<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Cv;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $clearCache = function () {
            Cache::forget('layout.global_data');
        };

        Profile::saved($clearCache);
        Profile::deleted($clearCache);

        Experience::saved($clearCache);
        Experience::deleted($clearCache);

        Skill::saved($clearCache);
        Skill::deleted($clearCache);

        Project::saved($clearCache);
        Project::deleted($clearCache);

        Cv::saved($clearCache);
        Cv::deleted($clearCache);
    }
}
