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
        $profile = Cache::remember('profile.data', 86400, function () {
            return Profile::first();
        });

        $collections = Cache::remember('home_collections.data', 86400, function () {
            return [
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        $experiences = $collections['experiences'];
        $educations = $collections['educations'];
        $skills = $collections['skills'];
        $featuredProjects = $collections['featuredProjects'];

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
        $profile = Cache::remember('profile.data', 86400, function () {
            return Profile::first();
        });

        // Ensure page is a valid positive integer to prevent DoS attacks through cache exhaustion
        $page = filter_var(request()->get('page', 1), FILTER_VALIDATE_INT, [
            'options' => ['default' => 1, 'min_range' => 1]
        ]);

        // Using TTL instead of rememberForever. This prevents infinite cache growth
        // over time since pagination can theoretically create many keys.
        $projects = Cache::remember("projects.page.{$page}", 86400, function () {
            return Project::ordered()->paginate(12);
        });
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
