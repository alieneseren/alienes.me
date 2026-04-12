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
        // ⚡ Bolt Performance Optimization:
        // Cache the entire home page data payload to reduce the number of queries
        // from 5 to 0 on subsequent page loads. The cache is automatically cleared
        // when any of these models are saved or deleted via the ClearsHomePageCache trait.
        // Expected impact: Significant reduction in TTFB (Time to First Byte) and database load.
        $data = Cache::remember('home_page_data', 3600, function () {
            return [
                'profile' => Profile::first(),
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        return view('frontend.home', $data);
    }

    public function projects()
    {
        $profile = Profile::first();
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
