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
        $clearLayoutCache = function () {
            Cache::forget('layout.global_data');
        };

        Profile::saved($clearLayoutCache);
        Profile::deleted($clearLayoutCache);

        Experience::saved($clearLayoutCache);
        Experience::deleted($clearLayoutCache);

        Skill::saved($clearLayoutCache);
        Skill::deleted($clearLayoutCache);

        Project::saved($clearLayoutCache);
        Project::deleted($clearLayoutCache);

        Cv::saved($clearLayoutCache);
        Cv::deleted($clearLayoutCache);
    }
}
