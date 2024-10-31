<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Support\Facades\Auth;

class LogVisit
{
    public function handle($request, Closure $next)
    {
        // Ghi lại thông tin truy cập
        Visit::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'visit_date' => now(),
        ]);

        return $next($request);
    }
}
