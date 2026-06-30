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
        // ⚡ Bolt: Veri güncellemelerinde önbelleğin otomatik temizlenmesini sağlıyoruz.
        $clearProfileCache = function () {
            Cache::forget('profile.data');
        };

        Profile::saved($clearProfileCache);
        Profile::deleted($clearProfileCache);

        $clearHomeCollectionsCache = function () {
            Cache::forget('home_collections.data');
        };

        $models = [Experience::class, Education::class, Skill::class, Project::class];

        foreach ($models as $model) {
            $model::saved($clearHomeCollectionsCache);
            $model::deleted($clearHomeCollectionsCache);
        }
    }
}
