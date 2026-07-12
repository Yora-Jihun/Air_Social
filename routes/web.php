<?php

use App\Livewire\Welcome;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\VerifyOtp;
use App\Livewire\Newsfeed\Index as Newsfeed;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('welcome');

Route::middleware(['guest', 'throttle:10,1'])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware(['auth', 'throttle:20,1'])->group(function () {
    Route::get('/verify-otp', VerifyOtp::class)->name('verification.notice');

    Route::middleware('verified')->group(function () {
        Route::get('/newsfeed', Newsfeed::class)->name('newsfeed');
    });
});