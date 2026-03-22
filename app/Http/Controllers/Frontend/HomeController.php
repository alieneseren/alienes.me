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
        // 24 saat (86400 saniye) önbelleğe alma
        $ttl = 86400;

        $profile = Cache::remember('profile', $ttl, function () {
            return Profile::first();
        });

        $experiences = Cache::remember('experiences', $ttl, function () {
            return Experience::ordered()->get();
        });

        $educations = Cache::remember('educations', $ttl, function () {
            return Education::ordered()->get();
        });

        $skills = Cache::remember('skills', $ttl, function () {
            return Skill::ordered()->get();
        });

        $featuredProjects = Cache::remember('featured_projects', $ttl, function () {
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
        // 24 saat önbelleğe alma
        $ttl = 86400;

        $profile = Cache::remember('profile', $ttl, function () {
            return Profile::first();
        });

        // Sayfalama kullanıldığı için cache tags kullanıyoruz (file cache driver tag desteklemezse fallback olarak düz query atılabilir veya veritabanı boyutunda paginate önbelleğe alınmayabilir)
        // Ancak bu proje genelinde paginated projeleri bir "projects" tag'i altında önbelleğe almak mantıklıdır. Redis vb yoksa cache temizlemek zor olabilir.
        // Bu yüzden en güvenli ve temiz yol, projeleri Cache::tags() ile etiketlemek olacaktır.

        $page = request()->get('page', 1);

        // Eger driver tag desteklemiyorsa (orn: file), etiket kullanmadan anahtar olusturuyoruz
        if (Cache::getStore() instanceof \Illuminate\Cache\TaggableStore) {
            $projects = Cache::tags(['projects'])->remember('projects_page_' . $page, $ttl, function () {
                return Project::ordered()->paginate(12);
            });
        } else {
             $projects = Cache::remember('projects_page_' . $page, $ttl, function () {
                return Project::ordered()->paginate(12);
            });
        }
        
        return view('frontend.projects', compact('profile', 'projects'));
    }
}
