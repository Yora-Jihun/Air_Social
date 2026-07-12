<div class="rounded-2xl bg-white p-8 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 sm:p-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Forgot your password?</h1>
        <p class="mt-1 text-sm text-gray-500">Enter your email and we'll send you a code to reset your password.</p>
    </div>

    @if ($sent)
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-100">
            If an account exists for <strong>{{ $email }}</strong>, we've sent a reset code to your inbox.
        </div>

        <a href="{{ route('reset.password') }}"
           class="mt-5 block w-full rounded-lg bg-brand px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand/40">
            Enter reset code
        </a>
    @else
        @if ($error)
            <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-100">
                {{ $error }}
            </div>
        @endif

        <form wire:submit="send" class="space-y-5">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model="email" autocomplete="email"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
                @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled"
                    class="w-full rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand/40">
                Send reset code
            </button>
        </form>
    @endif

    <p class="mt-6 text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="font-medium text-brand hover:text-brand-dark hover:underline">Back to login</a>
    </p>
</div>
