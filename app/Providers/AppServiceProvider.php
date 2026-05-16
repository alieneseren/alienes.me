<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ⚡ Bolt: Invalidate home page cache when portfolio models are updated
        $clearHomeCache = function () {
            \Illuminate\Support\Facades\Cache::forget('home.data');
        };

        \App\Models\Profile::saved($clearHomeCache);
        \App\Models\Profile::deleted($clearHomeCache);

        \App\Models\Experience::saved($clearHomeCache);
        \App\Models\Experience::deleted($clearHomeCache);

        \App\Models\Education::saved($clearHomeCache);
        \App\Models\Education::deleted($clearHomeCache);

        \App\Models\Skill::saved($clearHomeCache);
        \App\Models\Skill::deleted($clearHomeCache);

        \App\Models\Project::saved($clearHomeCache);
        \App\Models\Project::deleted($clearHomeCache);
    }
}
