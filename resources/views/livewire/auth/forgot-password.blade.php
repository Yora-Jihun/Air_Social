<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm p-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-2">Forgot your password?</h1>
    <p class="text-gray-500 mb-6">Enter your email and we'll send you a code to reset your password.</p>

    @if ($sent)
        <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
            If an account exists for <strong>{{ $email }}</strong>, we've sent a reset code to your inbox.
        </div>

        <a href="{{ route('reset.password') }}"
           class="mt-4 block w-full text-center bg-blue-600 text-white rounded-xl py-2 font-medium hover:bg-blue-700">
            Enter reset code
        </a>
    @else
        @if ($error) <div class="mb-4 text-sm text-red-600">{{ $error }}</div> @endif

        <form wire:submit="send" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model="email"
                       class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium hover:bg-blue-700">
                Send reset code
            </button>
        </form>
    @endif

    <a href="{{ route('login') }}" class="mt-4 block text-center text-sm text-blue-600 hover:underline">
        Back to login
    </a>
</div>
