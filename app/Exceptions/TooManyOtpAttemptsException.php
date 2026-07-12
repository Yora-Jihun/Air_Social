<?php

namespace App\Exceptions;

use Exception;

class TooManyOtpAttemptsException extends Exception
{
    public function __construct(public readonly int $retryAfterSeconds)
    {
        parent::__construct("Too many attempts. Try again in {$retryAfterSeconds} seconds.");
    }
}