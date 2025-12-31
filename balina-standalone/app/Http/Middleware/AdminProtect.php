<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminProtect
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // IP whitelist (comma separated in .env)
        $allowed = env('ADMIN_ALLOWED_IPS', null);
        if ($allowed) {
            $ips = array_filter(array_map('trim', explode(',', $allowed)));
            if (!in_array($request->ip(), $ips)) {
                return response('Forbidden', 403);
            }
        }

        // Optional admin secret token check
        $secret = env('ADMIN_SECRET_TOKEN', null);
        if ($secret) {
            $header = $request->header('X-Admin-Token');
            if (!$header || !hash_equals($secret, $header)) {
                return response('Forbidden', 403);
            }
        }

        return $next($request);
    }
}
