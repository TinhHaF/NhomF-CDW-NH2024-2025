<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password'); // Hiển thị form nhập email
    }

    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Gửi liên kết đặt lại mật khẩu qua email
        $status = Password::sendResetLink($request->only('email'));

        // Kiểm tra và hiển thị thông báo
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'We have emailed your password reset link!');
        } else {
            return back()->withErrors(['email' => 'Failed to send the password reset link.']);
        }
    }
}
