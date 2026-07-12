<?php

namespace App\Contracts;

use App\Models\User;

interface AuthServiceContract
{
    public function sendOtp(User $user): void;

    public function verifyOtp(User $user, string $code): bool;
}