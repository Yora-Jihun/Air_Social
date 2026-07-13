<?php

namespace App\Livewire\Auth;

use App\Contracts\AuthServiceContract;
use App\Exceptions\OtpResendThrottledException;
use App\Exceptions\TooManyOtpAttemptsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPassword extends Component
{
    public string $code = '';
    public array $digits = [];
    public string $password = '';
    public string $password_confirmation = '';
    public ?string $error = null;
    public bool $success = false;

    public function mount()
    {
        if (! session('otp_reset_email')) {
            return redirect()->route('forgot.password');
        }

        $this->digits = array_fill(0, config('otp.length'), '');
    }

    public function updatedDigits()
    {
        $this->code = implode('', array_map('strval', $this->digits));
    }

    public function resetPassword(AuthServiceContract $authService)
    {
        $this->error = null;

        $this->validate([
            'code' => ['required', 'digits:'.config('otp.length')],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $email = session('otp_reset_email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            session()->forget('otp_reset_email');
            return redirect()->route('forgot.password');
        }

        try {
            if (! $authService->verifyOtp($user, $this->code, AuthServiceContract::PURPOSE_PASSWORD)) {
                $this->error = 'Invalid code. Please try again.';
                return;
            }
        } catch (TooManyOtpAttemptsException $e) {
            $this->error = $e->getMessage();
            return;
        }

        $user->forceFill([
            'password' => Hash::make($this->password),
            'remember_token' => null,
        ])->save();

        session()->forget('otp_reset_email');

        $this->success = true;
    }

    public function resend(AuthServiceContract $authService)
    {
        $email = session('otp_reset_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (! $user) {
            return;
        }

        try {
            $authService->sendOtp($user, AuthServiceContract::PURPOSE_PASSWORD);
        } catch (OtpResendThrottledException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password')->layout('layouts.auth');
    }
}
