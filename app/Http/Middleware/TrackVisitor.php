<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorCount;

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
        }

        return $next($request);
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
