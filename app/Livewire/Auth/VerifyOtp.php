<?php

namespace App\Livewire\Auth;

use App\Contracts\AuthServiceContract;
use App\Exceptions\OtpResendThrottledException;
use App\Exceptions\TooManyOtpAttemptsException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerifyOtp extends Component
{
    public string $code = '';
    public ?string $error = null;

    public function verify(AuthServiceContract $authService)
    {
        $this->validate(['code' => ['required', 'digits:'.config('otp.length')]]);

        try {
            if (! $authService->verifyOtp(Auth::user(), $this->code, \App\Contracts\AuthServiceContract::PURPOSE_EMAIL)) {
                $this->error = 'Invalid code. Please try again.';
                return;
            }
        } catch (TooManyOtpAttemptsException $e) {
            $this->error = $e->getMessage();
            return;
        }

        Auth::user()->markEmailAsVerified();

        return redirect()->route('newsfeed');
    }

    public function resend(AuthServiceContract $authService)
    {
        try {
            $authService->sendOtp(Auth::user());
            session()->flash('status', 'A new code has been sent to your email.');
        } catch (OtpResendThrottledException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.auth.verify-otp')->layout('layouts.auth');
    }
}