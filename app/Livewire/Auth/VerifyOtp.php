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
    public array $digits = [];
    public ?string $error = null;
    public ?string $status = null;
    public int $resendCooldown = 0;

    public function mount(AuthServiceContract $authService)
    {
        $this->digits = array_fill(0, config('otp.length'), '');
        $this->resendCooldown = $authService->resendRemainingSeconds(
            Auth::user(),
            AuthServiceContract::PURPOSE_EMAIL
        );
    }

    public function updatedDigits()
    {
        $this->code = implode('', array_map('strval', $this->digits));
    }

    public function verify(AuthServiceContract $authService)
    {
        $this->error = null;
        $this->status = null;

        $this->validate(['code' => ['required', 'digits:'.config('otp.length')]]);

        try {
            if (! $authService->verifyOtp(Auth::user(), $this->code, AuthServiceContract::PURPOSE_EMAIL)) {
                $this->error = 'Invalid code. Please try again.';
                $this->dispatch('toast', message: $this->error, type: 'error');
                return;
            }
        } catch (TooManyOtpAttemptsException $e) {
            $this->error = $e->getMessage();
            $this->dispatch('toast', message: $this->error, type: 'error');
            return;
        }

        Auth::user()->markEmailAsVerified();

        return redirect()->route('newsfeed');
    }

    public function resend(AuthServiceContract $authService)
    {
        $this->error = null;
        $this->status = null;

        try {
            $authService->sendOtp(Auth::user());
            $this->status = 'A new code has been sent to your email.';
            $this->dispatch('toast', message: $this->status, type: 'success');
        } catch (OtpResendThrottledException $e) {
            $this->error = $e->getMessage();
            $this->dispatch('toast', message: $this->error, type: 'error');
        }

        $this->resendCooldown = $authService->resendRemainingSeconds(
            Auth::user(),
            AuthServiceContract::PURPOSE_EMAIL
        );
    }

    public function render()
    {
        return view('livewire.auth.verify-otp')->layout('layouts.auth');
    }
}
