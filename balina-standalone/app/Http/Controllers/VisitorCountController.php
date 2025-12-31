<?php

namespace App\Http\Controllers;

use App\Models\VisitorCount;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VisitorCountController extends Controller
{
    /**
     * ESP32 için bugünkü ziyaretçi sayısını ve anlık ziyaretçileri döndür
     * GET /api/visitor-count
     */
    public function today(): JsonResponse
    {
        $count = VisitorCount::getTodayCount();
        $activeVisitors = $this->getActiveVisitors();
        
        return response()->json([
            'date' => now()->toDateString(),
            'count' => $count,
            'active' => $activeVisitors,
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
            'active' => $this->getActiveVisitors(),
            'daily' => $stats,
        ]);
    }

    /**
     * Anlık aktif ziyaretçilerin detaylı listesi
     * GET /api/visitor-count/active
     */
    public function activeList(): JsonResponse
    {
        $activeVisitors = VisitorLog::getActiveVisitors(5);
        
        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'count' => $activeVisitors->count(),
            'visitors' => $activeVisitors->map(function ($visitor) {
                return [
                    'session_id' => substr($visitor->session_id, 0, 8) . '...', // Gizlilik için kısalt
                    'page' => $visitor->page_url,
                    'subdomain' => $visitor->subdomain,
                    'device' => $visitor->device_type,
                    'browser' => $visitor->browser,
                    'country' => $visitor->country,
                    'last_seen' => $visitor->created_at->diffForHumans(),
                ];
            }),
        ]);
    }

    /**
     * Son ziyaretçi logları (sayfa görüntülemeleri)
     * GET /api/visitor-count/logs
     */
    public function logs(Request $request): JsonResponse
    {
        $limit = min($request->input('limit', 50), 200);
        $logs = VisitorLog::getRecentLogs($limit);
        
        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'count' => $logs->count(),
            'logs' => $logs->map(function ($log) {
                return [
                    'id' => $log->id,
                    'session' => substr($log->session_id, 0, 8) . '...',
                    'page' => $log->page_url,
                    'subdomain' => $log->subdomain,
                    'referrer' => $log->referrer,
                    'device' => $log->device_type,
                    'browser' => $log->browser,
                    'os' => $log->os,
                    'country' => $log->country,
                    'city' => $log->city,
                    'time' => $log->created_at->toIso8601String(),
                    'time_ago' => $log->created_at->diffForHumans(),
                ];
            }),
        ]);
    }

    /**
     * Gerçek zamanlı stream (Server-Sent Events)
     * GET /api/visitor-count/stream
     */
    public function stream(): StreamedResponse
    {
        return response()->stream(function () {
            $lastId = 0;
            
            while (true) {
                // Son logları kontrol et
                $newLogs = VisitorLog::where('id', '>', $lastId)
                    ->orderBy('id', 'asc')
                    ->get();
                
                if ($newLogs->isNotEmpty()) {
                    $lastId = $newLogs->last()->id;
                    
                    foreach ($newLogs as $log) {
                        $data = [
                            'type' => 'new_visit',
                            'id' => $log->id,
                            'session' => substr($log->session_id, 0, 8) . '...',
                            'page' => $log->page_url,
                            'subdomain' => $log->subdomain,
                            'device' => $log->device_type,
                            'browser' => $log->browser,
                            'country' => $log->country,
                            'time' => $log->created_at->toIso8601String(),
                        ];
                        
                        echo "data: " . json_encode($data) . "\n\n";
                        ob_flush();
                        flush();
                    }
                }
                
                // Anlık durum gönder
                $status = [
                    'type' => 'status',
                    'timestamp' => now()->toIso8601String(),
                    'today_count' => VisitorCount::getTodayCount(),
                    'active_count' => $this->getActiveVisitors(),
                ];
                
                echo "data: " . json_encode($status) . "\n\n";
                ob_flush();
                flush();
                
                // 3 saniye bekle
                sleep(3);
                
                // Bağlantı kesildi mi kontrol et
                if (connection_aborted()) {
                    break;
                }
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Dashboard için özet istatistikler
     * GET /api/visitor-count/dashboard
     */
    public function dashboard(): JsonResponse
    {
        $todayCount = VisitorCount::getTodayCount();
        $yesterdayCount = VisitorCount::getCountByDate(now()->subDay()->toDateString());
        $weeklyStats = VisitorCount::where('visit_date', '>=', now()->subDays(7))
            ->orderBy('visit_date', 'asc')
            ->get(['visit_date', 'count']);
        
        $pageStats = VisitorLog::getTodayPageStats();
        $deviceStats = VisitorLog::getDeviceStats();
        $subdomainStats = VisitorLog::getSubdomainStats();
        $activeVisitors = VisitorLog::getActiveVisitors(5);
        
        // Saat bazlı bugünkü trafik
        $hourlyTraffic = VisitorLog::whereDate('created_at', today())
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as views')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
        
        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'summary' => [
                'today' => $todayCount,
                'yesterday' => $yesterdayCount,
                'change' => $todayCount - $yesterdayCount,
                'change_percent' => $yesterdayCount > 0 
                    ? round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100, 1) 
                    : 0,
                'active_now' => $activeVisitors->count(),
                'total_week' => $weeklyStats->sum('count'),
            ],
            'active_visitors' => $activeVisitors->map(function ($v) {
                return [
                    'session' => substr($v->session_id, 0, 8) . '...',
                    'page' => $v->page_url,
                    'subdomain' => $v->subdomain,
                    'device' => $v->device_type,
                    'browser' => $v->browser,
                    'country' => $v->country,
                    'last_seen' => $v->created_at->diffForHumans(),
                ];
            }),
            'weekly_chart' => $weeklyStats->map(function ($s) {
                return [
                    'date' => $s->visit_date,
                    'count' => $s->count,
                ];
            }),
            'hourly_traffic' => $hourlyTraffic,
            'top_pages' => $pageStats->take(10),
            'devices' => $deviceStats,
            'subdomains' => $subdomainStats,
        ]);
    }

    /**
     * Anlık aktif ziyaretçi sayısını al (son 2 dakika içinde aktif olanlar)
     */
    private function getActiveVisitors(): int
    {
        $activeKey = 'active_visitors';
        $visitors = Cache::get($activeKey, []);
        
        // Son 2 dakika içinde aktif olanları say
        $twoMinutesAgo = now()->subMinutes(2)->timestamp;
        $activeCount = 0;
        
        foreach ($visitors as $timestamp) {
            if ($timestamp >= $twoMinutesAgo) {
                $activeCount++;
            }
        }
        
        return $activeCount;
    }

    /**
     * ESP32'den gelen veriyi kaydet (gunluk_kullani veritabanı)
     * POST /api/visitor-count/esp32-log
     */
    public function esp32Log(Request $request): JsonResponse
    {
        $visitorCount = $request->input('count', 0);
        $token = $request->input('token');
        
        // Basit güvenlik kontrolü
        if ($token !== env('ESP32_API_TOKEN', 'esp32_secret_token_2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        try {
            // gunluk_kullani veritabanına bağlan
            $connection = DB::connection('gunluk');
            $now = now();
            
            // Yeni kayıt ekle
            $connection->table('esp32_visitor_log')->insert([
                'visitor_count' => $visitorCount,
                'recorded_at' => $now,
                'created_at' => $now,
            ]);
            
            // Akıllı silme mantığı: 
            // Son 1 dakika içinde aynı ziyaretçi sayısına sahip kayıtları kontrol et
            $oneMinuteAgo = $now->copy()->subMinute();
            
            // Son 1 dakika içindeki aynı count değerine sahip kayıtları al
            $duplicates = $connection->table('esp32_visitor_log')
                ->where('visitor_count', $visitorCount)
                ->where('recorded_at', '>=', $oneMinuteAgo)
                ->orderBy('recorded_at', 'asc')
                ->get();
            
            // Eğer 60 veya daha fazla aynı değer varsa, ilk 1 hariç hepsini sil
            if ($duplicates->count() >= 60) {
                $idsToDelete = $duplicates->skip(1)->pluck('id')->toArray();
                if (!empty($idsToDelete)) {
                    $connection->table('esp32_visitor_log')
                        ->whereIn('id', $idsToDelete)
                        ->delete();
                }
            }

            // Son 1 dakika için her visitor_count değerinden sadece 1 kayıt tut
            $minuteStart = $now->copy()->second(0)->microsecond(0);
            $minuteEnd = $minuteStart->copy()->addMinute();

            $recordsInMinute = $connection->table('esp32_visitor_log')
                ->where('recorded_at', '>=', $minuteStart)
                ->where('recorded_at', '<', $minuteEnd)
                ->orderBy('recorded_at', 'asc')
                ->get();

            $grouped = $recordsInMinute->groupBy('visitor_count');

            foreach ($grouped as $group) {
                if ($group->count() > 1) {
                    $idsToDelete = $group->skip(1)->pluck('id')->toArray();
                    if (!empty($idsToDelete)) {
                        $connection->table('esp32_visitor_log')
                            ->whereIn('id', $idsToDelete)
                            ->delete();
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Logged successfully',
                'count' => $visitorCount,
                'time' => $now->toDateTimeString(),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ESP32 log temizleme (eski kayıtları sil)
     * DELETE /api/visitor-count/esp32-cleanup
     */
    public function esp32Cleanup(Request $request): JsonResponse
    {
        $token = $request->input('token');
        
        if ($token !== env('ESP32_API_TOKEN', 'esp32_secret_token_2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        try {
            $connection = DB::connection('gunluk');
            
            // 7 günden eski kayıtları sil
            $deleted = $connection->table('esp32_visitor_log')
                ->where('recorded_at', '<', now()->subDays(7))
                ->delete();
            
            return response()->json([
                'success' => true,
                'deleted' => $deleted,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
