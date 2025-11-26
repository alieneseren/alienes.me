<?php

namespace App\Http\Controllers;

use App\Models\StudyCategory;
use App\Models\StudyNote;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    // Çalışma notları ana sayfa - kategorileri listele
    public function index()
    {
        $categories = StudyCategory::where('is_active', true)
            ->withCount('activeNotes')
            ->orderBy('order')
            ->get();

        return view('study.index', compact('categories'));
    }

    // Kategori detay - notları listele
    public function category($slug)
    {
        $category = StudyCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $notes = $category->activeNotes()->orderBy('order')->get();

        return view('study.category', compact('category', 'notes'));
    }

    // Not görüntüle
    public function show($categorySlug, $noteSlug)
    {
        $category = StudyCategory::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $note = StudyNote::where('slug', $noteSlug)
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->firstOrFail();

        // Görüntülenme sayısını artır
        $note->incrementViews();

        // HTML dosyasını oku
        $filePath = public_path($note->file_path);
        $content = file_exists($filePath) ? file_get_contents($filePath) : '<p>Dosya bulunamadı.</p>';

        // Diğer notları getir (sidebar için)
        $allNotes = $category->activeNotes()->get();

        return view('study.show', compact('category', 'note', 'content', 'allNotes'));
    }
}
