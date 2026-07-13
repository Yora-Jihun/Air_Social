<x-card>
    <div class="p-4">
        <div class="flex items-center gap-3">
            <x-avatar :src="$avatar" :name="$name" size="lg" />
            <div class="min-w-0">
                <p class="truncate font-semibold text-gray-900">{{ $name }}</p>
                <p class="text-xs text-gray-500">View your profile</p>
            </div>
        </div>

        <a href="#"
           class="mt-4 block w-full rounded-lg border border-gray-300 py-2 text-center text-sm font-medium text-gray-700 transition hover:bg-gray-50">
            View profile
        </a>
    </div>
</x-card>
