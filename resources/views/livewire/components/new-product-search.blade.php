

<?php

declare(strict_types=1);


use function Livewire\Volt\{mount,on,state};


?>

<div class="relative ml-4 flow-root lg:ml-6">
    <button wire:click="$dispatch('openPanel', { component: 'modals.product-search' })" type="button"
        class="group -m-2 flex items-center p-2">
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
        
        <span class="sr-only">{{ __('items in cart, view cart') }}</span>
    </button>
</div>
