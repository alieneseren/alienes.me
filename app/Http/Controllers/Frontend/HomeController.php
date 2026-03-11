<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Cache;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        // ⚡ Bolt Optimizasyonu: Anasayfadaki tekrarlayan veritabanı sorgularını engellemek için
        // veriler 1 saat süreyle (3600 saniye) önbelleğe alındı. Bu sayede veritabanı yükü azalacak
        // ve sayfanın yüklenme süresi milisaniyeler seviyesinde kısalacaktır.

        $profile = Cache::remember('profile', 3600, function () {
            return Profile::first();
        });

        $experiences = Cache::remember('experiences', 3600, function () {
            return Experience::ordered()->get();
        });

        $educations = Cache::remember('educations', 3600, function () {
            return Education::ordered()->get();
        });

        $skills = Cache::remember('skills', 3600, function () {
            return Skill::ordered()->get();
        });

        $featuredProjects = Cache::remember('featured_projects', 3600, function () {
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
        // ⚡ Bolt Optimizasyonu: Projeler sayfasındaki veriler ve sayfalamalar
        // performansı artırmak amacıyla önbelleğe (1 saat) alındı.

        $profile = Cache::remember('profile', 3600, function () {
            return Profile::first();
        });

        $page = request()->get('page', 1);
        $projects = Cache::remember('projects_page_' . $page, 3600, function () {
            return Project::ordered()->paginate(12);
        });
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
