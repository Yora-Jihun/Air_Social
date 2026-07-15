<div class="overflow-auto rounded-xl border border-gray-200">
    <table class="w-full border-collapse text-left text-sm">
        <thead class="sticky top-0 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
            <tr>
                <th class="px-4 py-2.5">Photo</th>
                <th class="px-4 py-2.5">Date</th>
                <th class="px-4 py-2.5">Time</th>
                <th class="px-4 py-2.5">Location</th>
                <th class="px-4 py-2.5">Coordinate</th>
                <th class="px-4 py-2.5">Weather</th>
                <th class="px-4 py-2.5">Altitude</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($attendanceRecords as $rec)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center gap-3">
                            <x-avatar :src="$rec['avatar'] ?? null" :name="$rec['name']" size="sm" />
                            <span class="text-sm font-medium text-gray-800">{{ $rec['name'] }}</span>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-4 py-2.5 font-medium text-gray-800">{{ $rec['date'] }}</td>
                    <td class="whitespace-nowrap px-4 py-2.5 text-gray-600">{{ $rec['time'] }}</td>
                    <td class="px-4 py-2.5 text-gray-600">{{ $rec['location'] }}</td>
                    <td class="whitespace-nowrap px-4 py-2.5 font-mono text-xs text-gray-500">{{ $rec['coordinate'] }}</td>
                    <td class="whitespace-nowrap px-4 py-2.5 text-gray-600">{{ $rec['weather'] }}</td>
                    <td class="whitespace-nowrap px-4 py-2.5 text-gray-600">{{ $rec['altitude'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
