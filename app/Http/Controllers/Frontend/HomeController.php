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
        $profile = \Illuminate\Support\Facades\Cache::remember('profile_first', now()->addHours(24), fn() => Profile::first());
        $experiences = \Illuminate\Support\Facades\Cache::remember('experiences_ordered', now()->addHours(24), fn() => Experience::ordered()->get());
        $educations = \Illuminate\Support\Facades\Cache::remember('educations_ordered', now()->addHours(24), fn() => Education::ordered()->get());
        $skills = \Illuminate\Support\Facades\Cache::remember('skills_ordered', now()->addHours(24), fn() => Skill::ordered()->get());
        $featuredProjects = \Illuminate\Support\Facades\Cache::remember('featured_projects', now()->addHours(24), fn() => Project::featured()->ordered()->take(6)->get());

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
        $profile = \Illuminate\Support\Facades\Cache::remember('profile_first', now()->addHours(24), fn() => Profile::first());
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
