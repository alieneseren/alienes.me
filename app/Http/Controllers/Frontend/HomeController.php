<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // ⚡ Bolt Optimizasyonu: Veritabanı sorguları (DB Queries) cachelenerek N adet sorgu engellendi.
        // Beklenen Performans Artışı: Her anasayfa yüklendiğinde 5 adet gereksiz veritabanı sorgusunu 0'a indirir.
        $profile = Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        $homeCollections = Cache::rememberForever('home_collections.data', function () {
            return [
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        $experiences = $homeCollections['experiences'];
        $educations = $homeCollections['educations'];
        $skills = $homeCollections['skills'];
        $featuredProjects = $homeCollections['featuredProjects'];

        return view('frontend.home', compact(
            'profile',
            'experiences',
            'educations',
            'skills',
            'featuredProjects'
        ));
    }

    public function projects()
    {
        // ⚡ Bolt Optimizasyonu: Ortak profil verisi cache'den çekiliyor. Profil sayfasında sorgu sayısını 1 adet azaltır.
        $profile = Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
