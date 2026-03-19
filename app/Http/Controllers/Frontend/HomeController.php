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
        // Cache lifetime set to 3600 seconds (1 hour)
        $cacheTtl = 3600;

        $profile = Cache::remember('home.profile', $cacheTtl, fn() => Profile::first());
        $experiences = Cache::remember('home.experiences', $cacheTtl, fn() => Experience::ordered()->get());
        $educations = Cache::remember('home.educations', $cacheTtl, fn() => Education::ordered()->get());
        $skills = Cache::remember('home.skills', $cacheTtl, fn() => Skill::ordered()->get());
        $featuredProjects = Cache::remember('home.featuredProjects', $cacheTtl, fn() => Project::featured()->ordered()->take(6)->get());

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
        $cacheTtl = 3600;

        $profile = Cache::remember('home.profile', $cacheTtl, fn() => Profile::first());
        // Since pagination relies on query parameters (e.g. ?page=2), we cache based on the current page.
        $page = (int) request()->query('page', 1);
        $projects = Cache::remember("projects.page.{$page}", $cacheTtl, fn() => Project::ordered()->paginate(12));
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
