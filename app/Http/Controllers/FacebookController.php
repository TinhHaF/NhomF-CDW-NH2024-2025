<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
            } else {
                $newUser = User::create([
                    'username' => User::where('username', $user->name)->exists()
                        ? $user->name . '_' . uniqid()
                        : $user->name,
                    'email' => $user->email ?? $user->id . '@facebook.com',
                    'facebook_id' => $user->id,
                    'password' => Hash::make('123456dummy'),
                    'role' => '1', // Kiểm tra logic role nếu cần
                ]);

                Auth::login($newUser);
            }

            return redirect()->intended('/');
        } catch (\Exception $e) {
            Log::error('Error during Facebook login', ['error' => $e->getMessage()]);
            return redirect('/login')->with('error', 'Có lỗi xảy ra trong quá trình đăng nhập bằng Facebook.');
        }
    }
}
