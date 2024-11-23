<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class NewPasswordController extends Controller
{
    public function create(Request $request, $token)
    {
        // Token sẽ được sử dụng để kiểm tra trong quá trình xác thực
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }


    public function store(Request $request)
    {
        // Validate các trường nhập vào
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Thử đặt lại mật khẩu
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => bcrypt($password)])->save();
            }
        );

        // Trường hợp đặt lại mật khẩu thành công
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Mật khẩu của bạn đã được đặt lại!');
        }

        // Nếu token không hợp lệ, hiển thị lỗi ngay tại trang
        if ($status === Password::INVALID_TOKEN) {
            return view('auth.reset-password', [
                'token' => $request->token,
                'email' => $request->email,
                'error' => 'Link đặt lại mật khẩu không hợp lệ hoặc đã được sử dụng.'
            ]);
        }

        // Trường hợp khác (lỗi không rõ nguyên nhân)
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email,
            'error' => 'Có lỗi xảy ra khi đặt lại mật khẩu. Vui lòng thử lại.'
        ]);
    }
}
