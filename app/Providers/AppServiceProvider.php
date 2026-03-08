<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ⚡ Bolt: Caching static layout queries to prevent N+1 and repeated DB hits on every request
        // Reduces query count significantly on all frontend pages. Using 60 seconds TTL to ensure dynamic updates (like new projects or CVs) are visible quickly while still mitigating constant DB hits.
        View::composer('layouts.frontend', function ($view) {
            $layoutData = Cache::remember('frontend_layout_data', 60, function () {
                return [
                    'profile' => \App\Models\Profile::first(),
                    'hasExperiences' => \App\Models\Experience::exists(), // using exists() is faster than count() > 0
                    'hasSkills' => \App\Models\Skill::exists(),
                    'hasProjects' => \App\Models\Project::exists(),
                    'hasCv' => \App\Models\Cv::where('is_published', true)->exists(),
                ];
            });

            $view->with($layoutData);
        });
    }
}
