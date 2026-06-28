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
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        // Diğer anasayfa koleksiyonlarını tek bir cache anahtarında grupluyoruz
        $homeCollections = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.data', function () {
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
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        // Paginated verileri cachelemiyoruz (veya farklı bir key kullanmalıyız),
        // şu an sadece pagination yapıyoruz.
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
