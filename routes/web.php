<?php

use App\Livewire\Welcome;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\VerifyOtp;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Newsfeed\Index as Newsfeed;
use App\Livewire\Company\Show as CompanyShow;
use App\Livewire\Profile\Show as ProfileShow;
use App\Livewire\Messages\Index as Messages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('welcome')->middleware('guest');

Route::middleware(['guest', 'throttle:10,1'])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('forgot.password');
    Route::get('/reset-password', ResetPassword::class)->name('reset.password');
});

Route::middleware(['auth', 'throttle:20,1'])->group(function () {
    Route::get('/verify-otp', VerifyOtp::class)
        ->name('verification.notice')
        ->middleware('unverified');

    Route::middleware('verified')->group(function () {
        Route::get('/newsfeed', Newsfeed::class)->name('newsfeed');
        Route::get('/companies/{slug}', CompanyShow::class)->name('companies.show');
        Route::get('/profile', ProfileShow::class)->name('profile.show');
        Route::get('/messages', Messages::class)->name('messages.index');
    });
});

Route::post('/logout', function () {
    Auth::guard('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('welcome');
})->name('logout')->middleware('auth');