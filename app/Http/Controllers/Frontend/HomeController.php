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
        // ⚡ Bolt Optimization: Cache the profile to prevent an unnecessary query on every page load.
        // Expected impact: Eliminates 1 query per page visit. Invalidation handled in AppServiceProvider.
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        // ⚡ Bolt Optimization: Group the homepage collections into a single cache key.
        // Expected impact: Eliminates 4 N+1 style queries on the homepage. Reduces DB load to 0 queries on cache hit.
        $homeCollections = \Illuminate\Support\Facades\Cache::rememberForever('home_collections.data', function () {
            return [
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        $experiences = $homeCollections['experiences'];
        $educations = $homeCollections['educations'];
        $skills = $homeCollections['skills'];
        $featuredProjects = $homeCollections['featuredProjects'];

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
        // ⚡ Bolt Optimization: Reuse cached profile data.
        $profile = \Illuminate\Support\Facades\Cache::rememberForever('profile.data', function () {
            return Profile::first();
        });

        // Note: Paginated projects are intentionally not cached here due to variable ?page parameters.
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
