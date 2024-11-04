<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng không phải là admin, chuyển hướng
        if (!$request->user() || (!$request->user()->isAdmin() && !$request->user()->isAuthor())) {
            return redirect('/'); // Hoặc trang khác tùy vào yêu cầu của bạn
        }

        return $next($request);
    }
}
