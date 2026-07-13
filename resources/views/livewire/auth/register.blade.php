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
                    <x-icon name="user" class="h-5 w-5" />
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
                <input id="password" type="password" x-bind:type="show ? 'text' : 'password'" wire:model="password" autocomplete="new-password"
                       placeholder="Create a password"
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

        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Confirm password</label>
            <div class="relative" x-data="{ show: false }">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <x-icon name="lock" class="h-5 w-5" />
                </span>
                <input id="password_confirmation" type="password" x-bind:type="show ? 'text' : 'password'" wire:model="password_confirmation" autocomplete="new-password"
                       placeholder="Re-enter your password"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-11 pr-11 text-sm text-[#0F172A] outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-4 focus:ring-brand/15">
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
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="group flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-brand to-brand-dark text-sm font-semibold text-white shadow-sm transition duration-150 hover:shadow-md hover:brightness-95 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-brand/30 disabled:cursor-not-allowed disabled:opacity-80">
            <span wire:loading.remove class="flex items-center gap-2">
                Create account
            </span>
            <span wire:loading class="opacity-80">Creating your account…</span>
        </button>
    </form>

    <div class="my-6 h-px bg-gray-100"></div>

    <p class="text-center text-sm text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-brand transition hover:text-brand-dark hover:underline">Sign in</a>
    </p>
</div>
