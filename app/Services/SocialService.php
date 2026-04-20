<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialService
{
    public function createOrLogin($socialUser, $provider)
    {
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } else {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'student_id' => '23810310083', 
                'password' => bcrypt(Str::random(16)), 
            ]);
        }

        \Illuminate\Support\Facades\Auth::login($user);

        return $user;
    }
}