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
        // ⚡ Bolt: Cache database queries for the homepage since they rarely change
        // This prevents 5 database queries on every homepage load (1 hour TTL)
        $ttl = 3600;

        $profile = Cache::remember('home_profile', $ttl, fn() => Profile::first());
        $experiences = Cache::remember('home_experiences', $ttl, fn() => Experience::ordered()->get());
        $educations = Cache::remember('home_educations', $ttl, fn() => Education::ordered()->get());
        $skills = Cache::remember('home_skills', $ttl, fn() => Skill::ordered()->get());
        $featuredProjects = Cache::remember('home_featured_projects', $ttl, fn() => Project::featured()->ordered()->take(6)->get());

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
        // ⚡ Bolt: Reuse the cached profile
        $profile = Cache::remember('home_profile', 3600, fn() => Profile::first());
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
