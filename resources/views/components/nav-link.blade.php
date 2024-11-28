@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center hover:text-green-900 text-sm text-green-500'
            : 'inline-flex items-center hover:text-green-900 text-sm text-gray-500';
@endphp

<a wire:navigate {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
