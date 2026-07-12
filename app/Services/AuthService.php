<?php

namespace App\Services;

use App\Contracts\AuthServiceContract;
use App\Exceptions\OtpResendThrottledException;
use App\Exceptions\TooManyOtpAttemptsException;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class AuthService implements AuthServiceContract
{
    public function sendOtp(User $user): void
    {
        $resendKey = $this->resendKey($user);

        if (RateLimiter::tooManyAttempts($resendKey, 1)) {
            throw new OtpResendThrottledException(
                RateLimiter::availableIn($resendKey)
            );
        }

        $code = random_int(
            10 ** (config('otp.length') - 1),
            (10 ** config('otp.length')) - 1
        );

        Cache::put(
            $this->codeKey($user),
            Hash::make($code),
            now()->addMinutes(config('otp.expires_in_minutes'))
        );

        Mail::to($user->email)->send(new OtpMail($code));

        RateLimiter::hit($resendKey, config('otp.resend_cooldown_seconds'));
        RateLimiter::clear($this->attemptsKey($user));
    }

    public function verifyOtp(User $user, string $code): bool
    {
        $attemptsKey = $this->attemptsKey($user);

        if (RateLimiter::tooManyAttempts($attemptsKey, config('otp.max_verify_attempts'))) {
            throw new TooManyOtpAttemptsException(
                RateLimiter::availableIn($attemptsKey)
            );
        }

        $hashed = Cache::get($this->codeKey($user));

        if (! $hashed || ! Hash::check($code, $hashed)) {
            RateLimiter::hit($attemptsKey, config('otp.verify_lockout_minutes') * 60);
            return false;
        }

        $user->markEmailAsVerified();

        Cache::forget($this->codeKey($user));
        RateLimiter::clear($attemptsKey);
        RateLimiter::clear($this->resendKey($user));

        return true;
    }

    protected function codeKey(User $user): string
    {
        return "otp:code:{$user->id}";
    }

    protected function attemptsKey(User $user): string
    {
        return "otp:attempts:{$user->id}";
    }

    protected function resendKey(User $user): string
    {
        return "otp:resend:{$user->id}";
    }
}