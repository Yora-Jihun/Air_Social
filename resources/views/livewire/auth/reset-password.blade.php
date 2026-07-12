<div class="rounded-2xl bg-white p-8 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 sm:p-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Reset your password</h1>
        <p class="mt-1 text-sm text-gray-500">Enter the code we sent to your email and choose a new password.</p>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-100">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="resetPassword" class="space-y-5" novalidate>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">Code</label>
            <input type="text" wire:model="code" maxlength="{{ config('otp.length') }}"
                   inputmode="numeric" autocomplete="one-time-code"
                   class="w-full rounded-lg border border-gray-300 px-4 py-3 text-center text-2xl font-semibold tracking-[0.5em] text-gray-900 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
            @error('code') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">New password</label>
            <input type="password" wire:model="password" autocomplete="new-password"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
            @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">Confirm password</label>
            <input type="password" wire:model="password_confirmation" autocomplete="new-password"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
        </div>

        @if ($error)
            <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-100">
                {{ $error }}
            </div>
        @endif

        <button type="submit" wire:loading.attr="disabled"
                class="w-full rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand/40">
            Reset password
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="font-medium text-brand hover:text-brand-dark hover:underline">Back to login</a>
    </p>
</div>
