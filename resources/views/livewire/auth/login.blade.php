<div x-data="loginForm()" class="w-full animate-auth-fade-in rounded-xl border border-[#E5E7EB] bg-white p-6 shadow-[0_8px_30px_-12px_rgba(2,6,23,0.08)] ring-1 ring-black/[0.02] sm:p-8">
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Air Social" class="mx-auto h-12 w-12 object-contain">
        <h1 class="mt-4 text-2xl font-bold tracking-tight text-[#0F172A]">Welcome back</h1>
        <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">Sign in to continue to Air Social.</p>
    </div>

    <form wire:submit="login" class="mt-8 space-y-5">
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <x-icon name="envelope" class="h-5 w-5" />
                </span>
                <input id="email" type="email" wire:model="email" autocomplete="email"
                       placeholder="you@example.com"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-4 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15 @error('email') border-red-400 @enderror">
            </div>
            @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
            <div class="relative" x-data="{ show: false }">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <x-icon name="lock" class="h-5 w-5" />
                </span>
                <input id="password" type="password" x-bind:type="show ? 'text' : 'password'" wire:model="password" autocomplete="current-password"
                       placeholder="Enter your password"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-11 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15 @error('password') border-red-400 @enderror">
                <button type="button" @click="show = !show" aria-label="Toggle password visibility"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 transition hover:text-gray-600 focus:outline-none">
                    <template x-if="!show">
                        <x-icon name="eye" class="h-5 w-5" />
                    </template>
                    <template x-if="show">
                        <x-icon name="eye-off" class="h-5 w-5" />
                    </template>
                </button>
            </div>
            @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" wire:model="remember" class="h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand">
                Remember me
            </label>
            <a href="{{ route('forgot.password') }}" class="text-sm font-medium text-brand transition hover:text-brand-dark hover:underline">
                Forgot your password?
            </a>
        </div>

        <button type="submit" wire:loading.attr="disabled" :disabled="throttled"
                class="group flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-brand to-brand-dark text-sm font-semibold text-white shadow-sm transition duration-150 hover:shadow-md hover:brightness-95 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-brand/30 disabled:cursor-not-allowed disabled:opacity-80">
            <span wire:loading.remove class="flex items-center gap-2">
                Log in
            </span>
            <span wire:loading class="opacity-80">Logging in…</span>
        </button>

        <template x-if="throttled">
            <p class="mt-4 text-center text-sm font-medium text-red-600">
                Too many login attempts. Please try again in <span x-text="cooldown"></span>s.
            </p>
        </template>
    </form>

    <div class="my-6 h-px bg-gray-100"></div>

    <p class="text-center text-sm text-gray-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-medium text-brand transition hover:text-brand-dark hover:underline">Sign up</a>
    </p>
</div>
