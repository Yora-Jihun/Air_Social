@props(['label' => 'Connect'])

<span x-data="{ state: 'idle' }" class="inline-flex">
    <button type="button" x-show="state === 'idle'" @click="state = 'pending'"
            class="inline-flex items-center gap-1.5 rounded-lg border border-blue-600 px-3 py-1.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-50">
        <x-icon name="user-plus" class="h-4 w-4" />
        {{ $label }}
    </button>
    <span x-show="state === 'pending'" x-cloak
          class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-semibold text-gray-500">
        <x-icon name="clock" class="h-4 w-4" />
        Pending
    </span>
</span>
