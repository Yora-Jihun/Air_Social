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
            $request->session()->flash(
                'verify_notice',
                "Thank you for trusting us with your account. "
                . "To keep things secure, please verify your email first "
                . "before using air_social. We've sent a code to your inbox."
            );

            try {
                app(AuthServiceContract::class)->sendOtp($user);
            } catch (\App\Exceptions\OtpResendThrottledException) {
                // A code was already sent recently (e.g. just registered,
                // or logging in on another device). Don't crash — the
                // existing cached code is still valid.
            }

            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('newsfeed'));
    }
}