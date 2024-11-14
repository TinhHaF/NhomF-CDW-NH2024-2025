<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

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
                // return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'username' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => Hash::make('123456dummy'),
                    'role' => '1'
                ]);

                Auth::login($newUser);
            }
            // Chuyển hướng ngay lập tức để tránh tái sử dụng callback
            return redirect()->intended('/');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
