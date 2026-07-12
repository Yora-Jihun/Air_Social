<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EnsureEmailNotVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('newsfeed');
        }

        return $next($request);
    }
}
