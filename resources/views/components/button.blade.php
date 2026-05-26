@props([
    'type' => 'primary',
    'buttonType' => 'button',
    'tag' => 'button',
    'href' => null,
    'icon' => null,
])

@php
    $baseClasses =
        'text-sm px-3 py-1.5 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors inline-flex items-center justify-center cursor-pointer gap-2';

    $styleClasses = \Illuminate\Support\Arr::toCssClasses([
        $baseClasses,

        match ($type) {
            // Solid buttons
            'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
            'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
            'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
            'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
            'warning' => 'bg-yellow-500 text-black hover:bg-yellow-600 focus:ring-yellow-400',
            'info' => 'bg-cyan-600 text-white hover:bg-cyan-700 focus:ring-cyan-500',

            // Ghost / link
            'ghost' => 'bg-transparent text-gray-600 hover:bg-gray-100 focus:ring-gray-400',
            'link' => 'bg-transparent text-blue-600 focus:ring-blue-500 px-0',

            default => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        },
    ]);
@endphp

<{{ $tag }}
    {{-- Button specific --}}
    @if ($tag === 'button')
        type="{{ $buttonType }}"
    @endif

    {{-- Anchor specific --}}
    @if ($tag === 'a' && $href)
        href="{{ $href }}"
    @endif

    {{ $attributes->merge(['class' => $styleClasses]) }}
>

    @if ($icon)
        @svg($icon, 'w-4 h-4 shrink-0')
    @endif

    <span>{{ $slot }}</span>

</{{ $tag }}>
