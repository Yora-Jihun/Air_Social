<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm p-8 text-center">
    <h1 class="text-2xl font-semibold text-gray-900 mb-2">Verify your email</h1>
    <p class="text-gray-500 mb-6">Enter the {{ config('otp.length') }}-digit code sent to {{ auth()->user()->email }}</p>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
    @endif

    <form wire:submit="verify" class="space-y-4">
        <input type="text" wire:model="code" maxlength="{{ config('otp.length') }}"
               class="w-full text-center text-2xl tracking-widest rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600"
               placeholder="{{ str_repeat('0', config('otp.length')) }}">
        @error('code') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        @if ($error) <div class="text-sm text-red-600">{{ $error }}</div> @endif

        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium hover:bg-blue-700">
            Verify
        </button>
    </form>

    <button wire:click="resend" class="mt-4 text-sm text-blue-600 hover:underline">
        Resend code
    </button>
</div>