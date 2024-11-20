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
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => bcrypt($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Your password has been reset!')
            : back()->withErrors(['email' => ['Failed to reset password.']]);
    }
}
