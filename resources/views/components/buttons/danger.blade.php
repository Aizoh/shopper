@props([
    'href' => null,
])

@if ($href)
    <x-link
        :$href
        {{ $attributes->twMerge(['class' => 'group relative py-2.5 inline-flex border border-transparent text-sm font-medium text-white shadow-sm focus:outline-none']) }}
    >
        <span
            class="absolute inset-0 z-0 transform border-2 border-red-600 p-1 transition-transform group-hover:translate-x-1 group-hover:translate-y-1 group-focus:-translate-y-1 group-focus:translate-x-1"
        ></span>
        <span class="absolute inset-0 bg-red-600 z-0"></span>
        <span class="relative w-full inline-flex items-center gap-2 justify-center">
            {{ $slot }}
        </span>
    </x-link>
@else
    <button
        {{ $attributes->twMerge(['class' => 'group relative py-2.5 inline-flex border border-transparent text-sm font-medium text-white shadow-sm focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed']) }}
    >
        <span
            class="absolute inset-0 z-0 transform border-2 border-red-600 p-1 transition-transform group-hover:translate-x-1 group-hover:translate-y-1 group-focus:-translate-y-1 group-focus:translate-x-1"
        ></span>
        <span class="absolute inset-0 bg-red-600 z-0"></span>
        <span class="relative w-full inline-flex items-center gap-2 justify-center">
            {{ $slot }}
        </span>
    </button>
@endif
