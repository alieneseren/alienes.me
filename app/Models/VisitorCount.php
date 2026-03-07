<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class VisitorCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_date',
        'count',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'count' => 'integer',
    ];

    /**
     * Bugünkü ziyaretçi sayısını artır
     */
    public static function incrementToday(): int
    {
        $today = now()->toDateString();
        $cacheKey = "visitor_count_{$today}";

        $visitor = self::firstOrCreate(
            ['visit_date' => $today],
            ['count' => 0]
        );

        $visitor->increment('count');

        // ⚡ Bolt: Cache today's count to prevent continuous DB queries in SSE stream
        Cache::put($cacheKey, $visitor->count, now()->addDay());

        return $visitor->count;
    }

    /**
     * Bugünkü ziyaretçi sayısını getir
     */
    public static function getTodayCount(): int
    {
        $today = now()->toDateString();
        $cacheKey = "visitor_count_{$today}";

        // ⚡ Bolt: Fetch from cache first (very important for SSE stream)
        return Cache::remember($cacheKey, now()->addDay(), function () use ($today) {
            return self::where('visit_date', $today)->value('count') ?? 0;
        });
    }

    /**
     * Belirli bir tarihin ziyaretçi sayısını getir
     */
    public static function getCountByDate(string $date): int
    {
        $cacheKey = "visitor_count_{$date}";

        // ⚡ Bolt: Historical counts don't change, cache them for 30 days
        return Cache::remember($cacheKey, now()->addDays(30), function () use ($date) {
            return self::where('visit_date', $date)->value('count') ?? 0;
        });
    }
}
