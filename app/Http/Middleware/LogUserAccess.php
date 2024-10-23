<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class LogUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ghi nhận số lượng online
        $onlineUsers = Cache::increment('online_users_count');
        
        // Ghi nhận số lượng truy cập hàng tuần
        $week = date('W');
        Cache::increment("weekly_visits_{$week}");
        
        // Ghi nhận số lượng truy cập hàng tháng
        $month = date('m-Y');
        Cache::increment("monthly_visits_{$month}");
        
        // Ghi nhận tổng số lượt truy cập
        Cache::increment('total_visits');

        return $next($request);
    }
}
