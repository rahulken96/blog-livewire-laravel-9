@props(['textColor', 'bgColor'])

@php
    $textColor = match ($textColor) {
        'gray' => 'text-gray-800',
        'green' => 'text-green-800',
        'blue' => 'text-blue-800',
        'red' => 'text-red-800',
        'yellow' => 'text-yellow-800',
        'white' => 'text-white-800',
        default => 'text-gray-800'
    };

    $bgColor = match ($bgColor) {
        'gray' => 'bg-gray-200',
        'green' => 'bg-green-200',
        'blue' => 'bg-blue-200',
        'red' => 'bg-red-200',
        'yellow' => 'bg-yellow-200',
        'white' => 'bg-white-200',
        default => 'bg-gray-200',
    };
@endphp

<button {{ $attributes }} href="#" class="{{ $textColor }} {{ $bgColor }} rounded-xl px-3 py-1 text-base">
    {{ $slot }}
</button>
