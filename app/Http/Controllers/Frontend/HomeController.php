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
        $profile = Cache::remember('profile.data', 3600, function () {
            return Profile::first();
        });

        $collections = Cache::remember('home_collections.data', 3600, function () {
            return [
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        return view('frontend.home', array_merge(['profile' => $profile], $collections));
    }

    public function projects()
    {
        $profile = Cache::remember('profile.data', 3600, function () {
            return Profile::first();
        });

        $page = request()->get('page', 1);
        $projects = Cache::remember('projects.page.' . $page, 3600, function () {
            return Project::ordered()->paginate(12);
        });
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
