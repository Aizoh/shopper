<?php

declare(strict_types=1);

use App\Models\Category;
use function Livewire\Volt\state;

state([
    'categories' => once(
        fn () => Category::isRoot()->scopes(['enabled'])->get()
    ),
]);

?>

{{-- <div class="hidden items-center gap-x-6 lg:flex">
    @foreach ($categories as $category)
        <x-nav.item :href="route('front.category', $category->slug)">{{ $category->name }}</x-nav.item>
    @endforeach
</div> --}}
<div>  <!-- ✅ Wrap everything inside one root element -->
    
    <!-- Desktop Navigation -->
    <div class="hidden items-center gap-x-6 lg:flex">
        @foreach ($categories as $category)
            <x-nav.item :href="route('front.category', $category->slug)">{{ $category->name }}</x-nav.item>
        @endforeach
    </div>

    <!-- Mobile Navigation Button -->
    <button id="mobile-menu-toggle" class="p-2 text-gray-400 hover:text-gray-500 lg:hidden">
        <span class="sr-only">Open menu</span>
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18m-7 6h7"/>
        </svg>
    </button>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="fixed inset-0 z-30 bg-white shadow-lg p-4 hidden lg:hidden">
        <button id="mobile-menu-close" class="absolute top-4 right-4 text-gray-500">
            <span class="sr-only">Close menu</span>
            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <nav class="mt-8">
            @foreach ($categories as $category)
                <x-nav.item :href="route('front.category', $category->slug)">{{ $category->name }}</x-nav.item>
            @endforeach
        </nav>
    </div>

</div>  <!-- ✅ Closing the single root element -->


