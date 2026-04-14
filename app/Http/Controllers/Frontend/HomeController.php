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
        // ⚡ Bolt: Cache database queries for the homepage for 24 hours to reduce load and speed up response times.
        $data = Cache::remember('home_page_data', 86400, function () {
            return [
                'profile' => Profile::first(),
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get()
            ];
        });

        return view('frontend.home', $data);
    }

    public function projects()
    {
        // ⚡ Bolt: Cache profile data for 24 hours to eliminate repetitive fetching on projects page.
        $profile = Cache::remember('projects_page_profile', 86400, function () {
            return Profile::first();
        });

        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
