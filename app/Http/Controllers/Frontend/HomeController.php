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
        // Cache for 10 minutes (600 seconds) to balance performance and freshness
        $ttl = 600;

        $profile = Cache::remember('frontend.profile', $ttl, function () {
            return Profile::first();
        });

        $experiences = Cache::remember('frontend.experiences', $ttl, function () {
            return Experience::ordered()->get();
        });

        $educations = Cache::remember('frontend.educations', $ttl, function () {
            return Education::ordered()->get();
        });

        $skills = Cache::remember('frontend.skills', $ttl, function () {
            return Skill::ordered()->get();
        });

        $featuredProjects = Cache::remember('frontend.featured_projects', $ttl, function () {
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
        $profile = Cache::remember('frontend.profile', 600, function () {
            return Profile::first();
        });

        // We don't cache pagination easily, so we leave it as is
        // but we saved 1 query above.
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
