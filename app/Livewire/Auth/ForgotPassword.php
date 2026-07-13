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
                $this->dispatch('toast', message: $this->error, type: 'error');
                return;
            }
        }

        session(['otp_reset_email' => $this->email]);
        $this->sent = true;
        $this->dispatch('toast', message: 'If that email exists, a reset code is on its way.', type: 'success');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('layouts.auth');
    }
}
