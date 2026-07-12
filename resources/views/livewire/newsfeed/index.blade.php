<div class="p-6">
    <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl mx-auto">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900">
                Welcome, {{ $username }} 👋
            </h1>
            <button wire:click="logout" wire:loading.attr="disabled"
                    class="text-sm text-gray-500 hover:text-red-600 hover:underline">
                Log out
            </button>
        </div>
    </div>
</div>