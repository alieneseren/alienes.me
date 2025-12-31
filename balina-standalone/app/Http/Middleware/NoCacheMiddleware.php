<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoCacheMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Cache kontrol header'ları ekle
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
                 ->header('Pragma', 'no-cache')
                 ->header('Expires', '0')
                 ->header('X-Accel-Expires', '0');
        
        return $response;
    }
}
