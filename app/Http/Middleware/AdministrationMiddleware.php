<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class AdministrationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập và có role là 2 (Admin)
        if (Auth::check() && Auth::user()->role == 2 || Auth::user()->role == 3) {
            return $next($request);
        }

        // Nếu không phải Admin, chuyển hướng hoặc trả về lỗi 403
        return redirect('/');
    }
}
