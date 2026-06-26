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
        $clearProfileCache = function () {
            \Illuminate\Support\Facades\Cache::forget('profile.data');
        };

        \App\Models\Profile::saved($clearProfileCache);
        \App\Models\Profile::deleted($clearProfileCache);

        $clearHomeCollectionsCache = function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.data');
        };

        \App\Models\Experience::saved($clearHomeCollectionsCache);
        \App\Models\Experience::deleted($clearHomeCollectionsCache);
        \App\Models\Education::saved($clearHomeCollectionsCache);
        \App\Models\Education::deleted($clearHomeCollectionsCache);
        \App\Models\Skill::saved($clearHomeCollectionsCache);
        \App\Models\Skill::deleted($clearHomeCollectionsCache);

        $clearProjectsCache = function () {
            \Illuminate\Support\Facades\Cache::forget('home_collections.data');
            // Projeler paginasyonla cache'lendiği için tüm sayfaları silmemiz gerekiyor.
            // Dosya tabanlı cache için etiket desteği olmadığından bu yöntemle sayfaları siliyoruz.
            // Sayfa sayısı dinamik olabileceği için 1-100 arası sayfaları silebiliriz (veya biliniyorsa Project::count() / 12)
            $maxPages = ceil(\App\Models\Project::count() / 12) + 5; // Birkaç sayfa fazladan silmek güvenlidir
            if ($maxPages < 10) $maxPages = 10;

            for ($i = 1; $i <= $maxPages; $i++) {
                \Illuminate\Support\Facades\Cache::forget('projects.page.' . $i);
            }
        };

        \App\Models\Project::saved($clearProjectsCache);
        \App\Models\Project::deleted($clearProjectsCache);
    }
}
