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
        // ⚡ Bolt: HomeController'da önbelleğe alınan profil verileri değiştiğinde cache temizlenir.
        Profile::saved(function () {
            Cache::forget('profile.data');
        });
        Profile::deleted(function () {
            Cache::forget('profile.data');
        });

        // ⚡ Bolt: Ana sayfa koleksiyon modellerinden herhangi biri güncellendiğinde/silindiğinde ortak önbelleği temizler.
        $clearHomeCollections = function () {
            Cache::forget('home_collections.data');
        };

        Experience::saved($clearHomeCollections);
        Experience::deleted($clearHomeCollections);

        Education::saved($clearHomeCollections);
        Education::deleted($clearHomeCollections);

        Skill::saved($clearHomeCollections);
        Skill::deleted($clearHomeCollections);

        Project::saved($clearHomeCollections);
        Project::deleted($clearHomeCollections);
    }
}
