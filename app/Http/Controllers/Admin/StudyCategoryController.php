<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudyCategoryController extends Controller
{
    public function index()
    {
        $categories = StudyCategory::withCount('notes')->orderBy('order')->get();
        return view('admin.study-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.study-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        $slug = Str::slug($request->name);
        
        StudyCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'icon' => $request->icon ?? '📚',
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.study-categories.index')
            ->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    public function edit(StudyCategory $studyCategory)
    {
        return view('admin.study-categories.edit', compact('studyCategory'));
    }

    public function update(Request $request, StudyCategory $studyCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        $studyCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon ?? '📚',
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.study-categories.index')
            ->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy(StudyCategory $studyCategory)
    {
        $studyCategory->delete();
        return redirect()->route('admin.study-categories.index')
            ->with('success', 'Kategori başarıyla silindi.');
    }
}
