<?php

namespace App\Livewire\Auth;

use App\Contracts\AuthServiceContract;
use App\Exceptions\TooManyOtpAttemptsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPassword extends Component
{
    public string $code = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?string $error = null;

    public function mount()
    {
        if (! session('otp_reset_email')) {
            return redirect()->route('forgot.password');
        }
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

        session()->flash('status', 'Your password has been reset. You can now log in.');

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.reset-password')->layout('layouts.auth');
    }
}
