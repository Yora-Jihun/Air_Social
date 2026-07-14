<x-card>
    <div class="p-4">
        <h3 class="px-1 text-sm font-semibold text-gray-900">My companies</h3>

        <ul class="mt-3 space-y-1">
            @foreach ($companies as $company)
                <li>
                    <a href="{{ route('companies.show', ['slug' => Str::slug($company['name'])]) }}"
                       class="flex items-center gap-3 rounded-lg px-1 py-2 hover:bg-gray-50">
                        <x-avatar :src="$company['avatar'] ?? null" :name="$company['name']" size="sm" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-gray-800">{{ $company['name'] }}</p>
                        </div>
                        <span @class([
                            'rounded-full px-2 py-0.5 text-[11px] font-semibold',
                            'bg-blue-50 text-blue-700' => ($company['role'] ?? '') === 'Admin',
                            'bg-gray-100 text-gray-600' => ($company['role'] ?? '') !== 'Admin',
                        ])>
                            {{ $company['role'] }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>

        <a href="#"
           class="mt-2 flex items-center justify-center gap-1.5 rounded-lg border border-dashed border-gray-300 py-2 text-sm font-medium text-gray-600 transition hover:border-blue-400 hover:text-blue-600">
            <x-icon name="plus" class="h-4 w-4" />
            Create a company
        </a>
    </div>
</x-card>
