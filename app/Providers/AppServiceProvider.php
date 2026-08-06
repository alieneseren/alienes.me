<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Cv;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer for frontend layout
        View::composer('layouts.frontend', function ($view) {
            $layoutData = Cache::remember('frontend_layout_data', 3600, function () {
                $profile = Profile::first();
                return [
                    'profile' => $profile,
                    'faviconUrl' => $profile && $profile->github_avatar_url
                        ? $profile->github_avatar_url
                        : asset('favicon.ico'),
                    'hasExperiences' => Experience::exists(),
                    'hasSkills' => Skill::exists(),
                    'hasProjects' => Project::exists(),
                    'hasPublishedCv' => Cv::where('is_published', true)->exists(),
                ];
            });

            $view->with('layoutData', $layoutData);
        });
    }
}
