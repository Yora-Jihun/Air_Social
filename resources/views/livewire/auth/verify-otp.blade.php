<div x-data="resetPasswordForm(@if($errors->has('code')) true @else false @endif, {{ $resendCooldown }})" x-cloak
     class="w-full animate-auth-fade-in rounded-xl border border-[#E5E7EB] bg-white p-6 shadow-[0_8px_30px_-12px_rgba(2,6,23,0.08)] ring-1 ring-black/[0.02] sm:p-8">
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Air Social" class="mx-auto h-12 w-12 object-contain">
        <h1 class="mt-4 text-2xl font-bold tracking-tight text-[#0F172A]">Verify your email</h1>
        <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">
            Enter the {{ config('otp.length') }}-digit code we sent to
            <span class="font-medium text-brand">{{ auth()->user()->email }}</span>.
        </p>
    </div>

    @if (session('verify_notice'))
        <div x-cloak x-init="$store.toast.show(@json(session('verify_notice')), 'info')"></div>
    @endif

    <form wire:submit="verify" class="mt-8 space-y-6" novalidate>
        <div>
            <label class="mb-3 block text-center text-sm font-medium text-gray-700">Verification code</label>
            <div x-data="otpInput()"
                 x-bind:class="otpError ? 'animate-auth-shake' : ''"
                 class="flex items-center justify-center gap-1.5 sm:gap-2">
                @for ($i = 0; $i < config('otp.length'); $i++)
                    <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code"
                           aria-label="Digit {{ $i + 1 }}"
                           x-ref="box{{ $i }}" wire:model="digits.{{ $i }}"
                           @input="filterDigit($event, {{ $i }})"
                           @keydown.backspace="onBackspace($event, {{ $i }})"
                           @keydown="onArrow($event, {{ $i }})"
                           @paste="onPaste($event, {{ $i }})"
                           x-bind:class="otpInvalid
                               ? 'border-red-400 ring-4 ring-red-100'
                               : 'border-[#D6DCE8] hover:border-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15'"
                           class="h-14 w-10 rounded-lg border bg-white text-center text-2xl font-bold text-[#0F172A] outline-none transition duration-150 ease-out focus:scale-105 sm:h-16 sm:w-12 sm:text-3xl">
                @endfor
            </div>
            @error('code') <p class="mt-3 text-center text-sm text-red-600">{{ $message }}</p> @enderror

            <div class="mt-5 flex items-center justify-center gap-2 text-sm text-gray-500">
                <x-icon name="clock" class="h-4 w-4" />
                <template x-if="!resendReady">
                    <span>Didn't receive the code?
                        <span class="font-medium text-brand" x-text="'Resend in ' + formatTime(cooldown)"></span>
                    </span>
                </template>
                <template x-if="resendReady">
                    <button type="button" @click="onResend()" wire:loading.attr="disabled" wire:target="resend"
                            class="inline-flex items-center gap-2 font-medium text-brand transition hover:text-brand-dark hover:underline focus:outline-none disabled:opacity-70">
                        <span wire:loading.remove wire:target="resend">Resend Code</span>
                        <span wire:loading wire:target="resend" class="opacity-80">Sending code…</span>
                    </button>
                </template>
            </div>
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="group flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-brand to-brand-dark text-sm font-semibold text-white shadow-sm transition duration-150 hover:shadow-md hover:brightness-95 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-brand/30 disabled:cursor-not-allowed disabled:opacity-80">
            <span wire:loading.remove class="flex items-center gap-2">
                Verify email
                <x-icon name="arrow-right" class="h-4 w-4 transition-transform duration-150 group-hover:translate-x-0.5" stroke-width="2" />
            </span>
            <span wire:loading class="opacity-80">Verifying code…</span>
        </button>
    </form>

    <div class="my-6 h-px bg-gray-100"></div>

    <p class="text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 font-medium text-gray-500 transition hover:text-brand">
                <x-icon name="arrow-left" class="h-4 w-4" stroke-width="2" />
            Back to Sign In
        </a>
    </p>
</div>
