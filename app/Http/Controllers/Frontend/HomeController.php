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
        // ⚡ Bolt Optimizasyonu: Profil, eğitim, deneyim, yetenekler ve projeler çok sık değişmez.
        // Cache süresi 1 gün (86400 saniye) olarak ayarlanarak her istekte 5 veritabanı sorgusu önlendi.
        // Bu değişiklik sayesinde veritabanı yükü azalırken İlk Byte Süresi (TTFB) hızlanacaktır.
        $profile = Cache::remember('home.profile', 86400, fn() => Profile::first());
        $experiences = Cache::remember('home.experiences', 86400, fn() => Experience::ordered()->get());
        $educations = Cache::remember('home.educations', 86400, fn() => Education::ordered()->get());
        $skills = Cache::remember('home.skills', 86400, fn() => Skill::ordered()->get());
        $featuredProjects = Cache::remember('home.featuredProjects', 86400, fn() => Project::featured()->ordered()->take(6)->get());

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
        // ⚡ Bolt Optimizasyonu: Ortak profil sorgusu cachelendi
        $profile = Cache::remember('home.profile', 86400, fn() => Profile::first());

        // Paginate olduğu için projeleri tümüyle cache'lemedik fakat sorgu süresi kabul edilebilir
        $projects = Project::ordered()->paginate(12);
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
