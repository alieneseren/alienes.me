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
        // ⚡ Bolt: Anasayfa önbellek temizleme (Cache Invalidation)
        // İlgili modeller eklendiğinde, güncellendiğinde veya silindiğinde önbelleği temizleyerek
        // anasayfada eski verilerin görünmesini engelliyoruz.
        \App\Models\Profile::saved(fn () => \Illuminate\Support\Facades\Cache::forget('profile.data'));
        \App\Models\Profile::deleted(fn () => \Illuminate\Support\Facades\Cache::forget('profile.data'));

        $homeModels = [
            \App\Models\Experience::class,
            \App\Models\Education::class,
            \App\Models\Skill::class,
            \App\Models\Project::class,
        ];

        foreach ($homeModels as $model) {
            $model::saved(fn () => \Illuminate\Support\Facades\Cache::forget('home_collections.data'));
            $model::deleted(fn () => \Illuminate\Support\Facades\Cache::forget('home_collections.data'));
        }
    }
}
