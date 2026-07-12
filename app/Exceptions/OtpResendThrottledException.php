<?php

namespace App\Exceptions;

use Exception;

class OtpResendThrottledException extends Exception
{
    public function __construct(public readonly int $retryAfterSeconds)
    {
        parent::__construct("Please wait {$retryAfterSeconds} seconds before requesting a new code.");
    }
}