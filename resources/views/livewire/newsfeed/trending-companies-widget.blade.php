<x-card>
    <div class="p-4">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-sm font-semibold text-gray-900">Trending companies</h3>
            <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View all</a>
        </div>

        <ul class="mt-3 space-y-1">
            @foreach ($companies as $company)
                <li>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-1 py-2 hover:bg-gray-50">
                        <x-avatar :src="$company['avatar'] ?? null" :name="$company['name']" size="sm" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-gray-800">{{ $company['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ number_format($company['members']) }} members</p>
                        </div>
                        <x-icon name="trending-up" class="h-4 w-4 text-green-500" />
                    </a>
                </li>
            @endforeach
        </ul>

        <a href="#" class="mt-2 block text-center text-sm font-medium text-blue-600 hover:underline">
            Explore more companies
        </a>
    </div>
</x-card>
