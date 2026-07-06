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
        // ⚡ Bolt: Cache frontend homepage data indefinitely. Cache is invalidated on model changes.
        $profile = Cache::rememberForever('home_profile', function () {
            return Profile::first();
        });

        $experiences = Cache::rememberForever('home_experiences', function () {
            return Experience::ordered()->get();
        });

        $educations = Cache::rememberForever('home_educations', function () {
            return Education::ordered()->get();
        });

        $skills = Cache::rememberForever('home_skills', function () {
            return Skill::ordered()->get();
        });

        $featuredProjects = Cache::rememberForever('home_featured_projects', function () {
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
        // ⚡ Bolt: Cache profile for projects page. Paginated projects are NOT cached to avoid DoS via cache exhaustion.
        $profile = Cache::rememberForever('home_profile', function () {
            return Profile::first();
        });

        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
