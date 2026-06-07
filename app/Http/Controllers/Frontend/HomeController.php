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
        // ⚡ Bolt: Cache profile data permanently to prevent unnecessary DB queries on every request.
        $profile = Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        // ⚡ Bolt: Cache homepage collections together to avoid N+1 and multiple queries per visit.
        $homeCollections = Cache::rememberForever('home_collections.data', function () {
            return [
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        return view('frontend.home', [
            'profile' => $profile,
            'experiences' => $homeCollections['experiences'],
            'educations' => $homeCollections['educations'],
            'skills' => $homeCollections['skills'],
            'featuredProjects' => $homeCollections['featuredProjects']
        ]);
    }

    public function projects()
    {
        // ⚡ Bolt: Use cached profile data here as well.
        $profile = Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
