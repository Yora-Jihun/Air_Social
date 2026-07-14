@props(['src' => null, 'name' => '', 'size' => 'md', 'online' => false])

@php
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-12 w-12 text-base',
        'xl' => 'h-16 w-16 text-lg',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];

    $initials = (string) collect(explode(' ', (string) $name))
        ->filter()
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->take(2)
        ->join('');
@endphp

<span class="relative inline-flex shrink-0 {{ $sizeClass }}">
    <span class="inline-flex h-full w-full shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 font-semibold text-blue-700 ring-1 ring-blue-200">
        @if ($src)
            <img src="{{ $src }}" alt="{{ $name }}" class="h-full w-full object-cover">
        @else
            {{ $initials }}
        @endif
    </span>

    @if ($online)
        <span class="absolute -bottom-0.5 -right-0.5 flex h-3 w-3">
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
            <span class="relative inline-flex h-3 w-3 rounded-full border-2 border-white bg-green-500"></span>
        </span>
    @endif
</span>
