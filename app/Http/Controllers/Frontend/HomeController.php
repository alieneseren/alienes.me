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
        // Önbellek süresi 24 saat (86400 saniye) olarak ayarlanmıştır.
        $homeData = Cache::remember('home_page_data', 86400, function () {
            return [
                'profile' => Profile::first(),
                'experiences' => Experience::ordered()->get(),
                'educations' => Education::ordered()->get(),
                'skills' => Skill::ordered()->get(),
                'featuredProjects' => Project::featured()->ordered()->take(6)->get(),
            ];
        });

        return view('frontend.home', [
            'profile' => $homeData['profile'],
            'experiences' => $homeData['experiences'],
            'educations' => $homeData['educations'],
            'skills' => $homeData['skills'],
            'featuredProjects' => $homeData['featuredProjects'],
        ]);
    }

    public function projects()
    {
        $profile = Profile::first();
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
