<?php

namespace App\Http\Responses;

use App\Contracts\AuthServiceContract;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {
            app(AuthServiceContract::class)->sendOtp($user);
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('newsfeed'));
    }
}