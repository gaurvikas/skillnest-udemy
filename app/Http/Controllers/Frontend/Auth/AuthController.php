<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'password' => Hash::make(Str::random(16)),
                'google_id' => $googleUser->id,
            ]

        );
        if ($googleUser->avatar) {
            $user->addMediaFromUrl($googleUser->avatar)->toMediaCollection('image');
        }

        if (! $user->google_id) {
            $user->update([
                'google_id' => $googleUser->id,
            ]);
        }

        Auth::login($user);

        if ($user->wasRecentlyCreated) {
            $user->assignRole('student'); //
            $user->notify(new WelcomeNotification(
                $user->name,
                to_route('index')
            ));
        }

        return redirect()
            ->intended(route('index'))
            ->with('message', 'Login successful via Google');
    }
}
