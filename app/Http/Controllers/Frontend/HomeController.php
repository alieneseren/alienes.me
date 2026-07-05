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
        // ⚡ BOLT OPTIMIZATION: Cache database queries for the homepage
        // The homepage gets the most traffic but its content changes rarely.
        // We use rememberForever here to skip 5 separate queries on every request.
        // Cache invalidation is handled safely via model events in AppServiceProvider.
        $profile = Cache::rememberForever('homepage_profile', function () {
            return Profile::first();
        });

        $experiences = Cache::rememberForever('homepage_experiences', function () {
            return Experience::ordered()->get();
        });

        $educations = Cache::rememberForever('homepage_educations', function () {
            return Education::ordered()->get();
        });

        $skills = Cache::rememberForever('homepage_skills', function () {
            return Skill::ordered()->get();
        });

        $featuredProjects = Cache::rememberForever('homepage_featured_projects', function () {
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
        // ⚡ BOLT OPTIMIZATION: Reuse cached profile data here as well.
        $profile = Cache::rememberForever('homepage_profile', function () {
            return Profile::first();
        });

        // Note: Deliberately skipping cache on paginated queries due to dynamic input parameters.
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
