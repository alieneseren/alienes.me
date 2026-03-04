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
        // ⚡ Bolt: Cache frontend home page queries for 1 hour to reduce database load and improve response time
        $profile = Cache::remember('home_profile', 3600, function () {
            return Profile::first();
        });

        $experiences = Cache::remember('home_experiences', 3600, function () {
            return Experience::ordered()->get();
        });

        $educations = Cache::remember('home_educations', 3600, function () {
            return Education::ordered()->get();
        });

        $skills = Cache::remember('home_skills', 3600, function () {
            return Skill::ordered()->get();
        });

        $featuredProjects = Cache::remember('home_featured_projects', 3600, function () {
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
