<div x-data="resetPasswordForm(@if($errors->has('code')) true @else false @endif, {{ $resendCooldown }})" x-cloak
     class="w-full animate-auth-fade-in rounded-xl border border-[#E5E7EB] bg-white p-6 shadow-[0_8px_30px_-12px_rgba(2,6,23,0.08)] ring-1 ring-black/[0.02] sm:p-8">

    {{-- ===================== SUCCESS STATE ===================== --}}
    <div x-show="$wire.success" x-cloak class="animate-auth-scale-in text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-50 text-green-600">
            <x-icon name="check" class="h-7 w-7" />
        </div>
        <h1 class="mt-6 text-2xl font-bold tracking-tight text-[#0F172A]">Password Updated</h1>
        <p class="mt-2 text-sm text-gray-500">Your password has been successfully updated.</p>
        <a href="{{ route('login') }}"
           class="mt-8 flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-brand to-brand-dark text-sm font-semibold text-white shadow-sm transition duration-150 hover:brightness-95 focus:outline-none focus:ring-4 focus:ring-brand/30">
            Continue to Sign In
        </a>
    </div>

    {{-- ===================== FORM STATE ===================== --}}
    <div x-show="!$wire.success">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-brand/10 text-brand">
                    <x-icon name="lock" class="h-5 w-5" />
            </div>
        <h1 class="mt-4 text-2xl font-bold tracking-tight text-[#0F172A]">Reset your password</h1>
        <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">
                We've sent a 6-digit verification code to
                <span class="font-medium text-brand">{{ session('otp_reset_email') ?? 'your email' }}</span>.
                Enter the code below and choose a new password.
            </p>
        </div>

        <form wire:submit="resetPassword" class="mt-8 space-y-6" novalidate>
            {{-- OTP SECTION --}}
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

                {{-- RESEND AREA --}}
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

            <div class="h-px bg-gray-100"></div>

            {{-- PASSWORD FIELD --}}
            <div>
                <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">New password</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <x-icon name="lock" class="h-5 w-5" />
                    </span>
                    <input id="password" type="password" x-bind:type="showPassword ? 'text' : 'password'" wire:model="password" autocomplete="new-password"
                           placeholder="Enter your new password"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-11 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15 @error('password') border-red-400 @enderror">
                    <button type="button" @click="showPassword = !showPassword" aria-label="Toggle password visibility"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 transition hover:text-gray-600 focus:outline-none">
                        <template x-if="!showPassword">
                            <x-icon name="eye" class="h-5 w-5" />
                        </template>
                        <template x-if="showPassword">
                            <x-icon name="eye-off" class="h-5 w-5" />
                        </template>
                    </button>
                </div>
                @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror

                {{-- STRENGTH INDICATOR --}}
                <div class="mt-3">
                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-gray-100">
                        <div class="h-full rounded-full transition-all duration-300"
                             x-bind:class="strengthBarClass"
                             x-bind:style="'width: ' + (password.length ? (strength * 25) : 0) + '%'"></div>
                    </div>
                    <div class="mt-1.5 flex items-center justify-between text-xs">
                        <span x-bind:class="strengthTextClass" x-text="strengthLabel"></span>
                        <span class="text-gray-400">Use 8 or more characters</span>
                    </div>
                </div>

                {{-- REQUIREMENTS --}}
                <div class="mt-3 grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    <div class="flex items-center gap-1.5" x-bindx-bind:class="reqLength ? 'text-green-600' : 'text-gray-400'">
                        <x-icon name="check" class="h-4 w-4 shrink-0" x-bind:class="reqLength ? 'opacity-100' : 'opacity-40'" stroke-width="2.2" />
                        At least 8 characters
                    </div>
                    <div class="flex items-center gap-1.5" x-bindx-bind:class="reqUpper ? 'text-green-600' : 'text-gray-400'">
                        <x-icon name="check" class="h-4 w-4 shrink-0" x-bind:class="reqUpper ? 'opacity-100' : 'opacity-40'" stroke-width="2.2" />
                        One uppercase letter
                    </div>
                    <div class="flex items-center gap-1.5" x-bindx-bind:class="reqNumber ? 'text-green-600' : 'text-gray-400'">
                        <x-icon name="check" class="h-4 w-4 shrink-0" x-bind:class="reqNumber ? 'opacity-100' : 'opacity-40'" stroke-width="2.2" />
                        One number
                    </div>
                    <div class="flex items-center gap-1.5" x-bindx-bind:class="reqSpecial ? 'text-green-600' : 'text-gray-400'">
                        <x-icon name="check" class="h-4 w-4 shrink-0" x-bind:class="reqSpecial ? 'opacity-100' : 'opacity-40'" stroke-width="2.2" />
                        One special character
                    </div>
                </div>
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Confirm password</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <x-icon name="lock" class="h-5 w-5" />
                    </span>
                    <input id="password_confirmation" type="password" x-bind:type="showConfirm ? 'text' : 'password'" wire:model="password_confirmation" autocomplete="new-password"
                           placeholder="Re-enter your new password"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-11 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15">
                    <button type="button" @click="showConfirm = !showConfirm" aria-label="Toggle password visibility"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 transition hover:text-gray-600 focus:outline-none">
                        <template x-if="!showConfirm">
                            <x-icon name="eye" class="h-5 w-5" />
                        </template>
                        <template x-if="showConfirm">
                            <x-icon name="eye-off" class="h-5 w-5" />
                        </template>
                    </button>
                </div>
            </div>

            {{-- PRIMARY BUTTON --}}
            <button type="submit" wire:loading.attr="disabled"
                    @click="if (password.length && passwordConfirmation.length && password !== passwordConfirmation) { $event.preventDefault(); $store.toast.show('The passwords do not match.', 'error'); }"
                    class="group flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-brand to-brand-dark text-sm font-semibold text-white shadow-sm transition duration-150 hover:shadow-md hover:brightness-95 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-brand/30 disabled:cursor-not-allowed disabled:opacity-80">
                <span wire:loading.remove class="flex items-center gap-2">
                    Reset Password
                <x-icon name="arrow-right" class="h-4 w-4 transition-transform duration-150 group-hover:translate-x-0.5" stroke-width="2" />
                </span>
                <span wire:loading class="opacity-80">Resetting password…</span>
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
</div>
