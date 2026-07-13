<div class="w-full animate-auth-fade-in rounded-xl border border-[#E5E7EB] bg-white p-6 shadow-[0_8px_30px_-12px_rgba(2,6,23,0.08)] ring-1 ring-black/[0.02] sm:p-8">
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Air Social" class="mx-auto h-12 w-12 object-contain">
        <h1 class="mt-4 text-2xl font-bold tracking-tight text-[#0F172A]">Forgot your password?</h1>
        <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">Enter your email and we'll send you a code to reset your password.</p>
    </div>

    @if ($sent)
        <a href="{{ route('reset.password') }}"
           class="group mt-5 flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-brand to-brand-dark text-sm font-semibold text-white shadow-sm transition duration-150 hover:shadow-md hover:brightness-95 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-brand/30">
            Enter reset code
            <svg class="h-4 w-4 transition-transform duration-150 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
            </svg>
        </a>
    @else
        <form wire:submit="send" class="mt-8 space-y-5">
            <div>
                <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L4.32 8.909A2.25 2.25 0 0 1 3.25 6.993V6.75"/>
                        </svg>
                    </span>
                    <input id="email" type="email" wire:model="email" autocomplete="email"
                           placeholder="you@example.com"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-4 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15 @error('email') border-red-400 @enderror">
                </div>
                @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled"
                    class="group flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-brand to-brand-dark text-sm font-semibold text-white shadow-sm transition duration-150 hover:shadow-md hover:brightness-95 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-brand/30 disabled:cursor-not-allowed disabled:opacity-80">
                <span wire:loading.remove class="flex items-center gap-2">
                    Send reset code
                    <svg class="h-4 w-4 transition-transform duration-150 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </span>
                <span wire:loading class="opacity-80">Sending reset code…</span>
            </button>
        </form>
    @endif

    <div class="my-6 h-px bg-gray-100"></div>

    <p class="text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 font-medium text-gray-500 transition hover:text-brand">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Back to login
        </a>
    </p>
</div>
