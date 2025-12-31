<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorCount;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\Cache;

class TrackVisitor
{
    /**
     * Ziyaretçileri takip et ve günlük sayıyı artır
     * Session ile aynı kullanıcının tekrar sayılmasını engelle
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sadece web sayfalarını say, API ve asset isteklerini sayma
        if ($this->shouldTrack($request)) {
            $sessionKey = 'visited_today_' . now()->toDateString();
            
            // Bu kullanıcı bugün daha önce sayılmadıysa
            if (!session()->has($sessionKey)) {
                VisitorCount::incrementToday();
                session()->put($sessionKey, true);
            }
            
            // Anlık ziyaretçi takibi (her sayfa görüntülemede güncelle)
            $this->trackActiveVisitor($request);
            
            // Detaylı log kaydı
            $this->logVisit($request);
        }

        return $next($request);
    }

    /**
     * Detaylı ziyaret logu kaydet
     */
    protected function logVisit(Request $request): void
    {
        try {
            $userAgent = $request->userAgent() ?? '';
            $deviceInfo = $this->parseUserAgent($userAgent);
            $subdomain = $this->getSubdomain($request);
            
            VisitorLog::create([
                'session_id' => session()->getId() ?: md5($request->ip() . $userAgent),
                'ip_address' => $request->ip(),
                'page_url' => '/' . ltrim($request->path(), '/'),
                'subdomain' => $subdomain,
                'page_title' => null, // JavaScript ile güncellenebilir
                'referrer' => $request->header('referer'),
                'user_agent' => substr($userAgent, 0, 500), // Max 500 karakter
                'country' => $this->getCountryFromIp($request->ip()),
                'city' => null,
                'device_type' => $deviceInfo['device'],
                'browser' => $deviceInfo['browser'],
                'os' => $deviceInfo['os'],
                'time_on_page' => null,
            ]);
        } catch (\Exception $e) {
            // Log hatası sessizce geç, kullanıcı deneyimini bozma
            \Log::error('Visitor log error: ' . $e->getMessage());
        }
    }

    /**
     * Request'ten subdomain'i çıkar
     */
    protected function getSubdomain(Request $request): ?string
    {
        $host = $request->getHost();
        
        // alienes.me için kontrol
        if ($host === 'alienes.me' || $host === 'www.alienes.me') {
            return null; // Ana domain
        }
        
        // Subdomain'i çıkar (örn: games.alienes.me -> games)
        if (str_ends_with($host, '.alienes.me')) {
            $subdomain = str_replace('.alienes.me', '', $host);
            return $subdomain ?: null;
        }
        
        return null;
    }

    /**
     * User Agent'tan cihaz bilgilerini çıkar
     */
    protected function parseUserAgent(string $userAgent): array
    {
        $ua = strtolower($userAgent);
        
        // Cihaz tipi
        $device = 'desktop';
        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') && str_contains($ua, 'mobile')) {
            $device = 'mobile';
        } elseif (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            $device = 'tablet';
        }
        
        // Tarayıcı
        $browser = 'Unknown';
        if (str_contains($ua, 'edg/') || str_contains($ua, 'edge/')) {
            $browser = 'Edge';
        } elseif (str_contains($ua, 'chrome/') && !str_contains($ua, 'edg/')) {
            $browser = 'Chrome';
        } elseif (str_contains($ua, 'firefox/')) {
            $browser = 'Firefox';
        } elseif (str_contains($ua, 'safari/') && !str_contains($ua, 'chrome/')) {
            $browser = 'Safari';
        } elseif (str_contains($ua, 'opera') || str_contains($ua, 'opr/')) {
            $browser = 'Opera';
        }
        
        // İşletim sistemi
        $os = 'Unknown';
        if (str_contains($ua, 'windows')) {
            $os = 'Windows';
        } elseif (str_contains($ua, 'macintosh') || str_contains($ua, 'mac os')) {
            $os = 'macOS';
        } elseif (str_contains($ua, 'linux') && !str_contains($ua, 'android')) {
            $os = 'Linux';
        } elseif (str_contains($ua, 'android')) {
            $os = 'Android';
        } elseif (str_contains($ua, 'iphone') || str_contains($ua, 'ipad') || str_contains($ua, 'ios')) {
            $os = 'iOS';
        }
        
        return [
            'device' => $device,
            'browser' => $browser,
            'os' => $os,
        ];
    }

    /**
     * IP adresinden ülke tahmini (basit versiyon)
     * Gerçek projede MaxMind GeoIP veya benzeri servis kullanılmalı
     */
    protected function getCountryFromIp(string $ip): ?string
    {
        // Localhost kontrolü
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return 'TR';
        }
        
        // Basit bir ücretsiz API kullanımı (rate limit var)
        // Production'da MaxMind veya ip-api.com kullanılmalı
        try {
            $cacheKey = 'geo_ip_' . md5($ip);
            
            return Cache::remember($cacheKey, 86400, function () use ($ip) {
                $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=countryCode", false, stream_context_create([
                    'http' => ['timeout' => 2]
                ]));
                
                if ($response) {
                    $data = json_decode($response, true);
                    return $data['countryCode'] ?? null;
                }
                
                return null;
            });
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Anlık aktif ziyaretçileri takip et
     */
    protected function trackActiveVisitor(Request $request): void
    {
        $visitorId = session()->getId() ?: $request->ip();
        $activeKey = 'active_visitors';
        
        // Mevcut aktif ziyaretçileri al
        $visitors = Cache::get($activeKey, []);
        
        // Bu ziyaretçinin son aktivite zamanını güncelle
        $visitors[$visitorId] = now()->timestamp;
        
        // 5 dakikadan eski kayıtları temizle
        $fiveMinutesAgo = now()->subMinutes(5)->timestamp;
        $visitors = array_filter($visitors, fn($timestamp) => $timestamp >= $fiveMinutesAgo);
        
        // Cache'e kaydet (10 dakika TTL)
        Cache::put($activeKey, $visitors, 600);
    }

    /**
     * Bu isteğin sayılıp sayılmayacağını belirle
     */
    protected function shouldTrack(Request $request): bool
    {
        // Sadece GET isteklerini say
        if (!$request->isMethod('GET')) {
            return false;
        }

        // API isteklerini sayma
        if ($request->is('api/*')) {
            return false;
        }

        // Asset dosyalarını sayma
        $excludedExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot'];
        $path = $request->path();
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($extension), $excludedExtensions)) {
            return false;
        }

        // Bot/crawler'ları sayma (opsiyonel)
        $userAgent = strtolower($request->userAgent() ?? '');
        $bots = ['bot', 'crawler', 'spider', 'slurp', 'googlebot', 'bingbot'];
        
        foreach ($bots as $bot) {
            if (str_contains($userAgent, $bot)) {
                return false;
            }
        }

        return true;
    }
}
