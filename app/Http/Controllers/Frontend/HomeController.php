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

        $experiences = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.experiences', function () {
            return Experience::ordered()->get();
        });

        $educations = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.educations', function () {
            return Education::ordered()->get();
        });

        $skills = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.skills', function () {
            return Skill::ordered()->get();
        });

        $featuredProjects = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.featured_projects', function () {
            return Project::featured()->ordered()->take(6)->get();
        });

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
