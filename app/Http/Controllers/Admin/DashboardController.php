<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'experiences' => Experience::count(),
            'educations' => Education::count(),
            'skills' => Skill::count(),
            'projects' => Project::count(),
            'contacts' => Contact::count(),
            'unread_contacts' => Contact::unread()->count(),
        ];

        $recentContacts = Contact::latest()->take(5)->get();
        $profile = Profile::first();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'profile'));
    }
}
