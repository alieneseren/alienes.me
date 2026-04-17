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
        // ⚡ Bolt Optimization:
        // Caching 5 expensive query calls that fetch the homepage data.
        // This prevents hitting the database on every home page visit.
        // Expected Impact: Reduces 5 queries to 0 (after first load), leading to faster load time.
        // The cache is properly invalidated via the ClearsHomePageCache Trait upon save/delete.
        $data = Cache::rememberForever('home_page_data', function () {
            return [
                'profile' => Profile::first(),
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        return view('frontend.home', [
            'profile' => $data['profile'],
            'experiences' => $data['experiences'],
            'educations' => $data['educations'],
            'skills' => $data['skills'],
            'featuredProjects' => $data['featuredProjects'],
        ]);
    }

    public function projects()
    {
        $profile = Profile::first();
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
