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
        // ⚡ Bolt: Anasayfa verileri için önbellekleme
        // Veritabanı sorgularını azaltmak için profil verilerini 'profile.data'
        // ve diğer koleksiyonları 'home_collections.data' altında önbelleğe alıyoruz.
        // Bu optimizasyon anasayfa yanıt süresini önemli ölçüde hızlandırır.
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        $collections = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.data', function () {
            return [
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        $experiences = $collections['experiences'];
        $educations = $collections['educations'];
        $skills = $collections['skills'];
        $featuredProjects = $collections['featuredProjects'];

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
        $profile = Profile::first();
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
