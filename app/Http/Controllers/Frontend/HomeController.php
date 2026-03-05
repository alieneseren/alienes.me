<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache for 24 hours (86400 seconds) since portfolio data doesn't change often
        $ttl = 86400;

        $profile = Cache::remember('home.profile', $ttl, function () {
            return Profile::first();
        });

        $experiences = Cache::remember('home.experiences', $ttl, function () {
            return Experience::ordered()->get();
        });

        $educations = Cache::remember('home.educations', $ttl, function () {
            return Education::ordered()->get();
        });

        $skills = Cache::remember('home.skills', $ttl, function () {
            return Skill::ordered()->get();
        });

        $featuredProjects = Cache::remember('home.featuredProjects', $ttl, function () {
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
        $ttl = 86400;
        $page = request()->get('page', 1);

        $profile = Cache::remember('home.profile', $ttl, function () {
            return Profile::first();
        });

        $projects = Cache::remember("projects.page.{$page}", $ttl, function () {
            return Project::ordered()->paginate(12);
        });

        return view('frontend.projects', compact('profile', 'projects'));
    }
}
