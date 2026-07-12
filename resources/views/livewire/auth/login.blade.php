<div class="rounded-2xl bg-white p-8 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 sm:p-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Welcome back</h1>
        <p class="mt-1 text-sm text-gray-500">Sign in to continue to Air Social.</p>
    </div>

    @if ($loginError)
        <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-100">
            {!! nl2br(e($loginError)) !!}
        </div>
    @endif

    <form wire:submit="login" class="space-y-5">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model="email" autocomplete="email"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
            @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
            <input type="password" wire:model="password" autocomplete="current-password"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
            @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" wire:model="remember" class="h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand">
                Remember me
            </label>
            <a href="{{ route('forgot.password') }}" class="text-sm font-medium text-brand hover:text-brand-dark hover:underline">
                Forgot your password?
            </a>
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="w-full rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand/40">
            Log in
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-medium text-brand hover:text-brand-dark hover:underline">Sign up</a>
    </p>
</div>
