<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use SerializesModels;

    public function __construct(public int $code) {}

    public function build()
    {
        return $this->subject('Your verification code')
            ->view('emails.otp');
    }
}