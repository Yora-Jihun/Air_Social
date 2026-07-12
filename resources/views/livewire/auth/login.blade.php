<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm p-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Welcome back</h1>

    <form wire:submit="login" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model="email"
                   class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600">
            @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" wire:model="password"
                   class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600">
            @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" wire:model="remember" class="rounded border-gray-300 text-blue-600">
            Remember me
        </label>

        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium hover:bg-blue-700">
            Log in
        </button>
    </form>
</div>