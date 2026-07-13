@props(['icon' => '', 'label' => '', 'href' => '#', 'active' => false])

<a href="{{ $href }}"
   @class([
       'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition',
       'bg-blue-50 text-blue-700' => $active,
       'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => ! $active,
   ])>
    <x-icon :name="$icon" class="h-5 w-5" />
    <span>{{ $label }}</span>
</a>
