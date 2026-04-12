<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogWebTraffic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hindari route admin dan storage
        if (!$request->is('admin*') && !$request->is('storage*') && !$request->is('api*') && !$request->is('_debugbar*')) {
            // Hindari multi hit pada sesi yang sama di hari yang sama
            $sessionKey = 'visited_' . today()->format('Y_m_d');
            if (!session()->has($sessionKey)) {
                
                // Anti-DDOS / Anti-Bot Spam: Batasi 1 IP maksimal mencetak 10 riwayat baru per menit
                $rateLimitKey = 'log_traffic_' . $request->ip();
                
                if (!\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($rateLimitKey, 10)) {
                    \Illuminate\Support\Facades\RateLimiter::hit($rateLimitKey, 60); // Blokir sementara jika lewati 10/menit
                    
                    \App\Models\WebTraffic::firstOrCreate(['date' => today()])->increment('visits');
                    
                    \App\Models\VisitorLog::create([
                        'ip_address' => $request->ip(),
                        'session_id' => session()->getId(),
                        'user_agent' => $request->userAgent(),
                        'url' => $request->fullUrl(),
                    ]);
                }

                // Tetap stempel session ini, bahkan kalau dia bot, agar tidak dicek ulang
                session()->put($sessionKey, true);
            }
        }

        return $next($request);
    }
}
