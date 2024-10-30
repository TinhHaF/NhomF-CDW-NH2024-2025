<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng có phải là quản trị viên không
        if (auth()->user()->is_admin) {
            return $next($request);
        }

        // Nếu không phải quản trị viên, chuyển hướng về trang không có quyền
        return redirect()->route('unauthorized');
    }
}
