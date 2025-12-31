<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip_address',
        'page_url',
        'subdomain',
        'page_title',
        'referrer',
        'user_agent',
        'country',
        'city',
        'device_type',
        'browser',
        'os',
        'time_on_page',
    ];

    protected $casts = [
        'time_on_page' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Son X dakika içindeki aktif ziyaretçileri getir
     */
    public static function getActiveVisitors(int $minutes = 5)
    {
        return self::where('created_at', '>=', now()->subMinutes($minutes))
            ->select('session_id', 'ip_address', 'page_url', 'subdomain', 'device_type', 'browser', 'country', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('session_id');
    }

    /**
     * Son X adet log kaydını getir
     */
    public static function getRecentLogs(int $limit = 50)
    {
        return self::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Bugünkü sayfa görüntüleme istatistikleri
     */
    public static function getTodayPageStats()
    {
        return self::whereDate('created_at', today())
            ->selectRaw('page_url, subdomain, COUNT(*) as views')
            ->groupBy('page_url', 'subdomain')
            ->orderByDesc('views')
            ->get();
    }

    /**
     * Cihaz dağılımı istatistikleri
     */
    public static function getDeviceStats()
    {
        return self::whereDate('created_at', today())
            ->selectRaw('device_type, COUNT(DISTINCT session_id) as count')
            ->groupBy('device_type')
            ->get();
    }

    /**
     * Subdomain bazlı istatistikler
     */
    public static function getSubdomainStats()
    {
        return self::whereDate('created_at', today())
            ->selectRaw("COALESCE(subdomain, 'ana-site') as site, COUNT(*) as views, COUNT(DISTINCT session_id) as visitors")
            ->groupBy('subdomain')
            ->orderByDesc('views')
            ->get();
    }
}
