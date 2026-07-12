<?php

namespace App\Livewire\Auth;

use App\Contracts\AuthServiceContract;
use App\Exceptions\OtpResendThrottledException;
use App\Models\User;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $email = '';
    public bool $sent = false;
    public ?string $error = null;

    public function send(AuthServiceContract $authService)
    {
        $this->error = null;

        $this->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $this->email)->first();

        if ($user) {
            try {
                $authService->sendOtp($user, AuthServiceContract::PURPOSE_PASSWORD);
            } catch (OtpResendThrottledException $e) {
                $this->error = $e->getMessage();
                return;
            }
        }

        session(['otp_reset_email' => $this->email]);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('layouts.auth');
    }
}
