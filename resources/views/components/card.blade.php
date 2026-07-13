@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'rounded-xl bg-white shadow-sm ring-1 ring-gray-200 ' . $class]) }}>
    {{ $slot }}
</div>
