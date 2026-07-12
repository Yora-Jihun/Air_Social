<div class="rounded-2xl bg-white p-8 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 sm:p-10">
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Verify your email</h1>
        <p class="mt-1 text-sm text-gray-500">Enter the {{ config('otp.length') }}-digit code sent to {{ auth()->user()->email }}</p>
    </div>

    @if (session('verify_notice'))
        <div class="mb-6 rounded-lg bg-blue-50 px-4 py-3 text-left text-sm text-blue-800 ring-1 ring-blue-100">
            {{ session('verify_notice') }}
        </div>
    @endif

    @if (session('status'))
        <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-100">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="verify" class="space-y-5">
        <div>
            <input type="text" wire:model="code" maxlength="{{ config('otp.length') }}"
                   inputmode="numeric" autocomplete="one-time-code"
                   class="w-full rounded-lg border border-gray-300 px-4 py-3 text-center text-2xl font-semibold tracking-[0.5em] text-gray-900 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
            @error('code') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            @if ($error) <p class="mt-1.5 text-sm text-red-600">{{ $error }}</p> @endif
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="w-full rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand/40">
            Verify
        </button>
    </form>

    <div class="mt-6 text-center">
        <button wire:click="resend" wire:loading.attr="disabled"
                class="text-sm font-medium text-brand hover:text-brand-dark hover:underline">
            Resend code
        </button>
    </div>
</div>
