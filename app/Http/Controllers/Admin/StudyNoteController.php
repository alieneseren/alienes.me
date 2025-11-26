<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyCategory;
use App\Models\StudyNote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class StudyNoteController extends Controller
{
    public function index()
    {
        $notes = StudyNote::with('category')->orderBy('category_id')->orderBy('order')->get();
        return view('admin.study-notes.index', compact('notes'));
    }

    public function create()
    {
        $categories = StudyCategory::orderBy('order')->get();
        return view('admin.study-notes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:study_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:html,htm,pdf,md|max:10240',
            'order' => 'nullable|integer',
        ]);

        $category = StudyCategory::findOrFail($request->category_id);
        $slug = Str::slug($request->title);
        
        // Dosyayı kaydet
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = $slug . '.' . $extension;
        
        // public/notes/kategori-slug/ dizinine kaydet
        $directory = public_path('notes/' . $category->slug);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        
        $file->move($directory, $filename);
        $filePath = 'notes/' . $category->slug . '/' . $filename;

        StudyNote::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'file_path' => $filePath,
            'type' => $extension,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.study-notes.index')
            ->with('success', 'Not başarıyla oluşturuldu.');
    }

    public function edit(StudyNote $studyNote)
    {
        $categories = StudyCategory::orderBy('order')->get();
        return view('admin.study-notes.edit', compact('studyNote', 'categories'));
    }

    public function update(Request $request, StudyNote $studyNote)
    {
        $request->validate([
            'category_id' => 'required|exists:study_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:html,htm,pdf,md|max:10240',
            'order' => 'nullable|integer',
        ]);

        $category = StudyCategory::findOrFail($request->category_id);
        $slug = Str::slug($request->title);
        $filePath = $studyNote->file_path;

        // Eğer yeni dosya yüklendiyse
        if ($request->hasFile('file')) {
            // Eski dosyayı sil
            $oldFile = public_path($studyNote->file_path);
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }

            // Yeni dosyayı kaydet
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = $slug . '.' . $extension;
            
            $directory = public_path('notes/' . $category->slug);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            
            $file->move($directory, $filename);
            $filePath = 'notes/' . $category->slug . '/' . $filename;
        }

        $studyNote->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'file_path' => $filePath,
            'type' => pathinfo($filePath, PATHINFO_EXTENSION),
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.study-notes.index')
            ->with('success', 'Not başarıyla güncellendi.');
    }

    public function destroy(StudyNote $studyNote)
    {
        // Dosyayı sil
        $file = public_path($studyNote->file_path);
        if (File::exists($file)) {
            File::delete($file);
        }

        $studyNote->delete();
        return redirect()->route('admin.study-notes.index')
            ->with('success', 'Not başarıyla silindi.');
    }
}
