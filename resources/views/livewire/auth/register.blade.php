<div class="rounded-2xl bg-white p-8 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 sm:p-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Create your account</h1>
        <p class="mt-1 text-sm text-gray-500">Join Air Social in a few seconds.</p>
    </div>

    <form wire:submit="register" class="space-y-5" novalidate>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model="name" autocomplete="name"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
            @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model="email" autocomplete="email"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
            @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
            <input type="password" wire:model="password" autocomplete="new-password"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
            @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700">Confirm password</label>
            <input type="password" wire:model="password_confirmation" autocomplete="new-password"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:border-brand focus:ring-2 focus:ring-brand/30">
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="w-full rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand/40">
            Create account
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-brand hover:text-brand-dark hover:underline">Sign in</a>
    </p>
</div>
