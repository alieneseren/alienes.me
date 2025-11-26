<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $experiences = Experience::orderBy('order')->get();
        $educations = Education::orderBy('order')->get();
        $skills = Skill::orderBy('category')->orderBy('order')->get();
        $projects = Project::where('is_featured', true)
            ->orderBy('order')
            ->limit(6)
            ->get();

        return view('home', compact('profile', 'experiences', 'educations', 'skills', 'projects'));
    }

    public function projects()
    {
        $projects = Project::orderBy('order')->paginate(9);
        return view('projects', compact('projects'));
    }
}
