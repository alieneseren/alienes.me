<?php

namespace App\Http\Controllers;

use App\Models\VisitorCount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VisitorCountController extends Controller
{
    /**
     * ESP32 için bugünkü ziyaretçi sayısını döndür
     * GET /api/visitor-count
     */
    public function today(): JsonResponse
    {
        $count = VisitorCount::getTodayCount();
        
        return response()->json([
            'date' => now()->toDateString(),
            'count' => $count,
        ]);
    }

    /**
     * ESP32 için sadece sayıyı döndür (minimal response)
     * GET /api/visitor-count/simple
     */
    public function simple(): string
    {
        return (string) VisitorCount::getTodayCount();
    }

    /**
     * Belirli bir tarihin ziyaretçi sayısını döndür
     * GET /api/visitor-count/{date}
     */
    public function byDate(string $date): JsonResponse
    {
        // Tarih formatını doğrula
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json([
                'error' => 'Invalid date format. Use YYYY-MM-DD',
            ], 400);
        }

        $count = VisitorCount::getCountByDate($date);
        
        return response()->json([
            'date' => $date,
            'count' => $count,
        ]);
    }

    /**
     * Son 7 günün istatistiklerini döndür
     * GET /api/visitor-count/stats
     */
    public function stats(): JsonResponse
    {
        $stats = VisitorCount::where('visit_date', '>=', now()->subDays(7))
            ->orderBy('visit_date', 'desc')
            ->get(['visit_date', 'count']);

        $total = $stats->sum('count');
        
        return response()->json([
            'total_7_days' => $total,
            'today' => VisitorCount::getTodayCount(),
            'daily' => $stats,
        ]);
    }
}
