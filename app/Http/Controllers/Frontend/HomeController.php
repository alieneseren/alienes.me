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
        // ⚡ Bolt: Cache all homepage data into a single query to prevent multiple DB calls
        $data = \Illuminate\Support\Facades\Cache::rememberForever('home.data', function () {
            return [
                'profile' => Profile::first(),
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        return view('frontend.home', $data);
    }

    public function projects()
    {
        $profile = Profile::first();
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
