<?php

namespace App\Providers;

use App\Contracts\AuthServiceContract;
use App\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AuthServiceContract::class, AuthService::class);
    }

    public function boot(): void
    {
        \Illuminate\Auth\Middleware\RedirectIfAuthenticated::redirectUsing(
            fn (\Illuminate\Http\Request $request) =>
                $request->user()?->hasVerifiedEmail()
                    ? route('newsfeed')
                    : route('verification.notice')
        );
    }
}