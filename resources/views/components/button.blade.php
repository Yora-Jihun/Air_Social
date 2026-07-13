@props(['href' => null, 'variant' => 'primary'])

@php
    $base = 'inline-flex items-center justify-center rounded-xl px-8 py-3 font-semibold transition shadow-md';

    $variants = [
        'primary' => 'bg-blue-600 text-white shadow-blue-200 hover:bg-blue-700 hover:shadow-lg',
        'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
