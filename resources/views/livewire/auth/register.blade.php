<div class="w-full animate-auth-fade-in rounded-xl border border-[#E5E7EB] bg-white p-6 shadow-[0_8px_30px_-12px_rgba(2,6,23,0.08)] ring-1 ring-black/[0.02] sm:p-8">
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Air Social" class="mx-auto h-12 w-12 object-contain">
        <h1 class="mt-4 text-2xl font-bold tracking-tight text-[#0F172A]">Create your account</h1>
        <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">Join Air Social in a few seconds.</p>
    </div>

    <form wire:submit="register" class="mt-8 space-y-5" novalidate>
        <div>
            <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Name</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0v.375c0 .621-.504 1.125-1.125 1.125H5.625a1.125 1.125 0 0 1-1.125-1.125v-.375Z"/>
                    </svg>
                </span>
                <input id="name" type="text" wire:model="name" autocomplete="name"
                       placeholder="Your full name"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-4 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15 @error('name') border-red-400 @enderror">
            </div>
            @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

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

        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
            <div class="relative" x-data="{ show: false }">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.5a4.5 4.5 0 1 0-9 0v3m-1.5 0h12a1.5 1.5 0 0 1 1.5 1.5v6a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 4.5 18v-6A1.5 1.5 0 0 1 6 10.5Z"/>
                    </svg>
                </span>
                <input id="password" type="password" x-bind:type="show ? 'text' : 'password'" wire:model="password" autocomplete="new-password"
                       placeholder="Create a password"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-11 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15 @error('password') border-red-400 @enderror">
                <button type="button" @click="show = !show" aria-label="Toggle password visibility"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 transition hover:text-gray-600 focus:outline-none">
                    <template x-if="!show">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z"/>
                            <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </template>
                    <template x-if="show">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.22A10.6 10.6 0 0 0 2.25 12s3.75 7.5 9.75 7.5c1.9 0 3.66-.54 5.13-1.46M6.3 6.3A10.6 10.6 0 0 1 12 4.5c6 0 9.75 7.5 9.75 7.5a10.6 10.6 0 0 1-2.13 3.02M3 3l18 18"/>
                        </svg>
                    </template>
                </button>
            </div>
            @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Confirm password</label>
            <div class="relative" x-data="{ show: false }">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.5a4.5 4.5 0 1 0-9 0v3m-1.5 0h12a1.5 1.5 0 0 1 1.5 1.5v6a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 4.5 18v-6A1.5 1.5 0 0 1 6 10.5Z"/>
                    </svg>
                </span>
                <input id="password_confirmation" type="password" x-bind:type="show ? 'text' : 'password'" wire:model="password_confirmation" autocomplete="new-password"
                       placeholder="Re-enter your password"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-11 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15">
                <button type="button" @click="show = !show" aria-label="Toggle password visibility"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 transition hover:text-gray-600 focus:outline-none">
                    <template x-if="!show">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z"/>
                            <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </template>
                    <template x-if="show">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.22A10.6 10.6 0 0 0 2.25 12s3.75 7.5 9.75 7.5c1.9 0 3.66-.54 5.13-1.46M6.3 6.3A10.6 10.6 0 0 1 12 4.5c6 0 9.75 7.5 9.75 7.5a10.6 10.6 0 0 1-2.13 3.02M3 3l18 18"/>
                        </svg>
                    </template>
                </button>
            </div>
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="group flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-brand to-brand-dark text-sm font-semibold text-white shadow-sm transition duration-150 hover:shadow-md hover:brightness-95 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-brand/30 disabled:cursor-not-allowed disabled:opacity-80">
            <span wire:loading.remove class="flex items-center gap-2">
                Create account
                <svg class="h-4 w-4 transition-transform duration-150 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25"/>
                    <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                </svg>
                Creating...
            </span>
        </button>
    </form>

    <div class="my-6 h-px bg-gray-100"></div>

    <p class="text-center text-sm text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-brand transition hover:text-brand-dark hover:underline">Sign in</a>
    </p>
</div>
