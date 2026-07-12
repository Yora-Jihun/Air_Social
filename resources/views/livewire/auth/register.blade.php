<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm p-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Create your account</h1>

    <form wire:submit="register" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model="name"
                   class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600">
            @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

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

        <div>
            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" wire:model="password_confirmation"
                   class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600">
        </div>

        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium hover:bg-blue-700">
            Register
        </button>
    </form>
</div>