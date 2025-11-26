<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use Illuminate\Http\Request;

class CvController extends Controller
{
    public function index()
    {
        $cvs = Cv::latest()->get();
        return view('admin.cv.index', compact('cvs'));
    }

    public function create()
    {
        return view('admin.cv.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'education' => 'nullable|array',
            'experience' => 'nullable|array',
            'skills' => 'nullable|array',
            'languages' => 'nullable|array',
            'social_links' => 'nullable|array',
        ]);

        $cv = Cv::create($data);

        return redirect()->route('admin.cv.index')->with('success', 'CV başarıyla oluşturuldu.');
    }

    public function edit(Cv $cv)
    {
        return view('admin.cv.form', compact('cv'));
    }

    public function update(Request $request, Cv $cv)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'education' => 'nullable|array',
            'experience' => 'nullable|array',
            'skills' => 'nullable|array',
            'languages' => 'nullable|array',
            'social_links' => 'nullable|array',
        ]);

        $cv->update($data);

        return redirect()->route('admin.cv.index')->with('success', 'CV başarıyla güncellendi.');
    }

    public function destroy(Cv $cv)
    {
        $cv->delete();
        return redirect()->route('admin.cv.index')->with('success', 'CV silindi.');
    }

    public function publish(Cv $cv)
    {
        // Diğer tüm CV'lerin yayın durumunu kaldır
        Cv::where('id', '!=', $cv->id)->update(['is_published' => false]);
        
        // Bu CV'yi yayınla/kaldır
        $cv->update(['is_published' => !$cv->is_published]);
        
        $status = $cv->is_published ? 'yayınlandı' : 'yayından kaldırıldı';
        return back()->with('success', "CV başarıyla $status.");
    }
}
