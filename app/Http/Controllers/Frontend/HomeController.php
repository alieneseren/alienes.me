<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        // ⚡ Bolt: Veritabanı sorgularını azaltmak için profil verilerini önbelleğe alıyoruz.
        // AppServiceProvider içinde model olayları dinlenerek cache invalidation sağlanmaktadır.
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        // ⚡ Bolt: Ana sayfada gösterilen koleksiyonları (deneyimler, eğitimler, yetenekler ve projeler)
        // tek bir anahtar altında önbelleğe alarak 4 gereksiz sorgunun (N+1 benzeri yüklerin) önüne geçiyoruz.
        $homeData = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.data', function () {
            return [
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        return view('frontend.home', [
            'profile' => $profile,
            'experiences' => $homeData['experiences'],
            'educations' => $homeData['educations'],
            'skills' => $homeData['skills'],
            'featuredProjects' => $homeData['featuredProjects'],
        ]);
    }

    public function projects()
    {
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
