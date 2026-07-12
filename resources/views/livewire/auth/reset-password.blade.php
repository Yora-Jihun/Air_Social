<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm p-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-2">Reset your password</h1>
    <p class="text-gray-500 mb-6">Enter the code we sent to your email and choose a new password.</p>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
    @endif

    <form wire:submit="resetPassword" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Code</label>
            <input type="text" wire:model="code" maxlength="{{ config('otp.length') }}"
                   class="mt-1 block w-full text-center text-2xl tracking-widest rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600"
                   placeholder="{{ str_repeat('0', config('otp.length')) }}">
            @error('code') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">New password</label>
            <input type="password" wire:model="password"
                   class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600">
            @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Confirm password</label>
            <input type="password" wire:model="password_confirmation"
                   class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600">
        </div>

        @if ($error) <div class="text-sm text-red-600">{{ $error }}</div> @endif

        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium hover:bg-blue-700">
            Reset password
        </button>
    </form>

    <a href="{{ route('login') }}" class="mt-4 block text-center text-sm text-blue-600 hover:underline">
        Back to login
    </a>
</div>
