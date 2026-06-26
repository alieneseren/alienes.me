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

        $collections = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.data', function () {
            return [
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get()
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
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        $page = filter_var(request()->get('page', 1), FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);
        $projects = \Illuminate\Support\Facades\Cache::rememberForever('projects.page.' . $page, function () {
            return Project::ordered()->paginate(12);
        });
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
