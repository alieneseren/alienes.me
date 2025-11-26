<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::ordered()->get();
        $categories = Skill::distinct()->pluck('category');
        return view('admin.skills.index', compact('skills', 'categories'));
    }

    public function create()
    {
        $categories = Skill::distinct()->pluck('category');
        return view('admin.skills.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'proficiency' => 'required|integer|min:0|max:100',
            'order' => 'integer',
        ]);

        Skill::create($request->all());

        return redirect()->route('admin.skills.index')->with('success', 'Yetenek başarıyla eklendi.');
    }

    public function edit(Skill $skill)
    {
        $categories = Skill::distinct()->pluck('category');
        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'proficiency' => 'required|integer|min:0|max:100',
            'order' => 'integer',
        ]);

        $skill->update($request->all());

        return redirect()->route('admin.skills.index')->with('success', 'Yetenek başarıyla güncellendi.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', 'Yetenek başarıyla silindi.');
    }
}
