@props(['name', 'fill' => 'none'])

@php
    $body = config("icons.{$name}");
@endphp

@if ($body)
<svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge([
    'viewBox' => '0 0 24 24',
    'fill' => $fill,
    'stroke' => 'currentColor',
    'stroke-width' => '1.8',
]) }}>
    {!! $body !!}
</svg>
@endif
