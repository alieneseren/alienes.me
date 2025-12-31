<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Project Service
 * 
 * Proje CRUD işlemleri ve iş mantığı
 */
class ProjectService
{
    protected const CACHE_TTL = 3600; // 1 saat

    /**
     * Tüm projeleri getir (filtreleme ve pagination ile)
     */
    public function getProjects(array $filters = [], int $perPage = 12): mixed
    {
        $query = Project::query()
            ->with(['technologies'])
            ->where('is_published', true);

        // Kategori filtresi
        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        // Teknoloji filtresi
        if (!empty($filters['technology'])) {
            $query->whereHas('technologies', function ($q) use ($filters) {
                $q->where('slug', $filters['technology']);
            });
        }

        // Durum filtresi
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Öne çıkan filtresi
        if (!empty($filters['featured'])) {
            $query->where('is_featured', true);
        }

        // Sıralama
        $sortBy = $filters['sort'] ?? 'order';
        $sortDir = $filters['direction'] ?? 'asc';
        
        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    /**
     * Öne çıkan projeleri getir (cache'li)
     */
    public function getFeaturedProjects(int $limit = 6): Collection
    {
        return Cache::remember('projects.featured', self::CACHE_TTL, function () use ($limit) {
            return Project::query()
                ->with(['technologies'])
                ->where('is_published', true)
                ->where('is_featured', true)
                ->orderBy('order')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Tek proje getir (slug ile)
     */
    public function getProjectBySlug(string $slug): ?Project
    {
        return Cache::remember("project.{$slug}", self::CACHE_TTL, function () use ($slug) {
            return Project::query()
                ->with(['technologies', 'comments' => function ($q) {
                    $q->where('is_approved', true)->latest()->limit(10);
                }])
                ->where('slug', $slug)
                ->where('is_published', true)
                ->first();
        });
    }

    /**
     * Yeni proje oluştur
     */
    public function createProject(array $data): Project
    {
        // Slug oluştur
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        
        // Unique slug garantisi
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);

        $project = Project::create($data);

        // Teknolojileri ekle
        if (!empty($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        }

        $this->clearCache();

        return $project->load('technologies');
    }

    /**
     * Proje güncelle
     */
    public function updateProject(Project $project, array $data): Project
    {
        // Slug değişmişse kontrol et
        if (isset($data['title']) && !isset($data['slug'])) {
            $newSlug = Str::slug($data['title']);
            if ($newSlug !== $project->slug) {
                $data['slug'] = $this->ensureUniqueSlug($newSlug, $project->id);
            }
        }

        $project->update($data);

        // Teknolojileri güncelle
        if (isset($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        }

        $this->clearCache();

        return $project->fresh('technologies');
    }

    /**
     * Proje sil
     */
    public function deleteProject(Project $project): bool
    {
        $result = $project->delete();
        $this->clearCache();
        return $result;
    }

    /**
     * Görüntüleme sayısını artır
     */
    public function incrementViewCount(Project $project): void
    {
        $project->increment('view_count');
    }

    /**
     * Beğeni ekle/çıkar
     */
    public function toggleLike(Project $project, int $userId): bool
    {
        // TODO: Likes tablosu oluşturulunca implement edilecek
        $project->increment('like_count');
        return true;
    }

    /**
     * Kategorileri getir
     */
    public function getCategories(): Collection
    {
        return Cache::remember('projects.categories', self::CACHE_TTL, function () {
            return Project::query()
                ->where('is_published', true)
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category');
        });
    }

    /**
     * İstatistikleri getir
     */
    public function getStats(): array
    {
        return Cache::remember('projects.stats', self::CACHE_TTL, function () {
            return [
                'total' => Project::count(),
                'published' => Project::where('is_published', true)->count(),
                'completed' => Project::where('status', 'completed')->count(),
                'in_progress' => Project::where('status', 'in_progress')->count(),
                'total_views' => Project::sum('view_count'),
                'total_likes' => Project::sum('like_count'),
            ];
        });
    }

    /**
     * Unique slug garantisi
     */
    protected function ensureUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $query = Project::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if (!$query->exists()) {
            return $slug;
        }

        $counter = 1;
        while (Project::where('slug', "{$slug}-{$counter}")->exists()) {
            $counter++;
        }

        return "{$slug}-{$counter}";
    }

    /**
     * Cache'i temizle
     */
    public function clearCache(): void
    {
        Cache::forget('projects.featured');
        Cache::forget('projects.categories');
        Cache::forget('projects.stats');
        
        // Tüm proje cache'lerini temizle
        // Pattern-based cache clear için Redis gerekli
    }
}
