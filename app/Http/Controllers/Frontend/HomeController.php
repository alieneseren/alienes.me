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
            'featuredProjects' => $homeData['featuredProjects']
        ]);
    }

    public function projects()
    {
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        // Paginator cache etmek sorunlu olabilir, ama query cache yapılabilir.
        // Cacheing paginated results efficiently requires request page awareness.
        // We'll keep it simple and just cache the first page or cache the query itself.
        // Actually, just cache the profile here. It reduces queries.
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
