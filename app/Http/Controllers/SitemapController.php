<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use App\Models\StudyNote;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        // Static pages
        $urls[] = ['loc' => URL::to('/'), 'lastmod' => now()->toAtomString(), 'changefreq' => 'daily', 'priority' => '1.0'];
        $urls[] = ['loc' => URL::to('/projects'), 'lastmod' => now()->toAtomString(), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => URL::to('/games'), 'lastmod' => now()->toAtomString(), 'changefreq' => 'weekly', 'priority' => '0.7'];
        $urls[] = ['loc' => URL::to('/contact'), 'lastmod' => now()->toAtomString(), 'changefreq' => 'monthly', 'priority' => '0.5'];

        // Study notes (if any)
        // Optimizasyon: N+1 problemini çözmek için category ilişkisini eager load ediyoruz
        $notes = StudyNote::with('category')->where('is_active', true)->orderBy('updated_at', 'desc')->get();
        foreach ($notes as $note) {
            $categorySlug = $note->category ? $note->category->slug : 'study';
            $urls[] = ['loc' => URL::to('/study/' . $categorySlug . '/' . $note->slug), 'lastmod' => $note->updated_at->toAtomString(), 'changefreq' => 'monthly', 'priority' => '0.6'];
        }

        // Build XML
        $xml = view('sitemap', compact('urls'));

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
