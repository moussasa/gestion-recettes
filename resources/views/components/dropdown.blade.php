@props(['align' => 'right', 'width' => '48'])

@php
$alignmentClasses = [
    'left' => 'origin-top-left left-0',
    'top' => 'origin-top',
    'right' => 'origin-top-right right-0',
];

$widthClass = [
    '48' => 'w-48',
][$width];
@endphp

<div class="relative" x-data="{ open: false }">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open" @click.away="open = false"
        class="absolute z-50 mt-2 {{ $widthClass }} rounded-md shadow-lg {{ $alignmentClasses[$align] }}"
        style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
            {{ $content }}
        </div>
    </div>
</div>
