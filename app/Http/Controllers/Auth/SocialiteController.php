<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            Auth::login($user);
            return redirect()->intended('dashboard');
        }

        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->id,
            ]);
            Auth::login($user);
            return redirect()->intended('dashboard');
        }

        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => bcrypt(Str::random(16)),
            'google_id' => $googleUser->id,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->intended('dashboard');
    }
}
