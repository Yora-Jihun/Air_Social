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
    public function sendOtp(User $user, string $purpose = self::PURPOSE_EMAIL): void
    {
        $resendKey = $this->resendKey($user, $purpose);

        if (RateLimiter::tooManyAttempts($resendKey, 1)) {
            throw new OtpResendThrottledException(
                RateLimiter::availableIn($resendKey)
            );
        }

        $code = random_int(
            (int) (10 ** (config('otp.length') - 1)),
            (int) ((10 ** config('otp.length')) - 1)
        );

        Cache::put(
            $this->codeKey($user, $purpose),
            Hash::make($code),
            now()->addMinutes(config('otp.expires_in_minutes'))
        );

        Mail::to($user->email)->send(new OtpMail($code, $purpose));

        RateLimiter::hit($resendKey, config('otp.resend_cooldown_seconds'));
        RateLimiter::clear($this->attemptsKey($user, $purpose));
    }

    public function verifyOtp(User $user, string $code, string $purpose = self::PURPOSE_EMAIL): bool
    {
        $attemptsKey = $this->attemptsKey($user, $purpose);

        if (RateLimiter::tooManyAttempts($attemptsKey, config('otp.max_verify_attempts'))) {
            throw new TooManyOtpAttemptsException(
                RateLimiter::availableIn($attemptsKey)
            );
        }

        $hashed = Cache::get($this->codeKey($user, $purpose));

        if (! $hashed || ! Hash::check($code, $hashed)) {
            RateLimiter::hit($attemptsKey, config('otp.verify_lockout_minutes') * 60);
            return false;
        }

        Cache::forget($this->codeKey($user, $purpose));
        RateLimiter::clear($attemptsKey);
        RateLimiter::clear($this->resendKey($user, $purpose));

        return true;
    }

    public function resendRemainingSeconds(User $user, string $purpose = self::PURPOSE_EMAIL): int
    {
        return RateLimiter::availableIn($this->resendKey($user, $purpose));
    }

    protected function codeKey(User $user, string $purpose): string
    {
        return "otp:code:{$purpose}:{$user->id}";
    }

    protected function attemptsKey(User $user, string $purpose): string
    {
        return "otp:attempts:{$purpose}:{$user->id}";
    }

    protected function resendKey(User $user, string $purpose): string
    {
        return "otp:resend:{$purpose}:{$user->id}";
    }
}
