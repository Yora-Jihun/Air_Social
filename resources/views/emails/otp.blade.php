@if ($purpose === \App\Contracts\AuthServiceContract::PURPOSE_PASSWORD)
    <p>You requested to reset your password. Your verification code is:</p>
@else
    <p>Your email verification code is:</p>
@endif

<h1 style="letter-spacing: 4px;">{{ $code }}</h1>

<p>This code expires in {{ config('otp.expires_in_minutes') }} minutes.</p>

@if ($purpose === \App\Contracts\AuthServiceContract::PURPOSE_PASSWORD)
    <p>If you did not request a password reset, you can ignore this email.</p>
@endif
