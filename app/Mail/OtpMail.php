<?php

namespace App\Mail;

use App\Contracts\AuthServiceContract;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public int $code,
        public string $purpose = AuthServiceContract::PURPOSE_EMAIL
    ) {}

    public function build()
    {
        $subject = $this->purpose === AuthServiceContract::PURPOSE_PASSWORD
            ? 'Reset your air_social password'
            : 'Verify your air_social email';

        return $this->subject($subject)->view('emails.otp');
    }
}
