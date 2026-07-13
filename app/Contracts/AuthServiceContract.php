<?php

namespace App\Contracts;

use App\Models\User;

interface AuthServiceContract
{
    public const PURPOSE_EMAIL = 'email';
    public const PURPOSE_PASSWORD = 'password';

    public function sendOtp(User $user, string $purpose = self::PURPOSE_EMAIL): void;

    public function verifyOtp(User $user, string $code, string $purpose = self::PURPOSE_EMAIL): bool;

    public function resendRemainingSeconds(User $user, string $purpose = self::PURPOSE_EMAIL): int;
}
