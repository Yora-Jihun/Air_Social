<x-card>
    <div class="p-4">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-sm font-semibold text-gray-900">People you may know</h3>
            <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View all</a>
        </div>

        <ul class="mt-3 space-y-3">
            @foreach ($people as $person)
                <li class="flex items-center gap-3">
                    <x-avatar :src="$person['avatar'] ?? null" :name="$person['name']" size="md" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-gray-800">{{ $person['name'] }}</p>
                        <p class="truncate text-xs text-gray-500">{{ $person['role'] }}</p>
                    </div>
                    <x-connect-button />
                </li>
            @endforeach
        </ul>
    </div>
</x-card>
