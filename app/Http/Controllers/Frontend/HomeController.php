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
        // ⚡ Bolt Optimization: Batch 5 separate queries into a single array
        // and cache it indefinitely. Reduces database load on the home page.
        // Invalidation is handled by the ClearsPortfolioCache trait on Models.
        $data = Cache::rememberForever('home_page_data', function () {
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
        // ⚡ Bolt Optimization: Cache the static profile data separately for the projects page
        $profile = Cache::rememberForever('portfolio_profile', function () {
            return Profile::first();
        });

        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
