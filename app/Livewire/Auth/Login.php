<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public ?string $loginError = null;
    public int $loginCooldown = 0;

    public function mount()
    {
        $email = session('login_throttle_email');
        $this->loginCooldown = $email ? RateLimiter::availableIn($this->throttleKeyFor($email)) : 0;
    }

    public function login()
    {
        $this->loginError = null;

        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());
            session(['login_throttle_email' => $this->email]);
            $this->loginCooldown = $seconds;
            return;
        }

        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $this->email)->first();

        if (! $user || ! Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            RateLimiter::hit($this->throttleKey());

            $this->loginError = "Invalid email or password\nPlease check your credentials and try again.";
            $this->dispatch('toast', message: $this->loginError, type: 'error');

            return;
        }

        RateLimiter::clear($this->throttleKey());
        session()->forget('login_throttle_email');
        request()->session()->regenerate();

        return app(LoginResponseContract::class)->toResponse(request());
    }

    protected function throttleKey(): string
    {
        return $this->throttleKeyFor($this->email);
    }

    protected function throttleKeyFor(string $email): string
    {
        return Str::transliterate(Str::lower($email).'|'.request()->ip());
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}