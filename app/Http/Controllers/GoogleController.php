<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $redirectUrl = 'http://localhost:8000/login/google/callback';

        return Socialite::driver('google')
            ->redirectUrl($redirectUrl) // set redirect URL trực tiếp
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')
                ->redirectUrl('http://localhost:8000/login/google/callback')
                ->user();

            // Tìm theo google_id hoặc email
            $finduser = User::where('google_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if ($finduser) {
                // Cập nhật google_id nếu user đăng ký bằng email
                if (!$finduser->google_id) {
                    $finduser->update(['google_id' => $user->id]);
                }
                Auth::login($finduser);
            } else {
                $newUser = User::create([
                    'username' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make('123456dummy'),
                    'role' => '1'
                ]);

                Auth::login($newUser);
            }

            return redirect()->intended('/');
        } catch (\Exception $e) {
            Log::error('Google callback error: ' . $e->getMessage());
        }
    }
}
