{{-- <div class="relative">
    <!-- Mobile Menu Button -->
    <button wire:click="toggleMenu" class="lg:hidden p-2 text-gray-600 hover:text-gray-800">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button> 

    <!-- Mobile Navigation -->
    @if ($isOpen)
        <div class="lg:hidden absolute top-full left-0 w-full bg-white border-t border-gray-200 shadow-lg">
            <div class="flex flex-col space-y-4 p-4">
                @foreach ($categories as $category)
                    <x-nav.item :href="route('front.category', $category->slug)">
                        {{ $category->name }}
                    </x-nav.item>
                @endforeach

                @auth
                    <livewire:components.account-menu />
                @else
                    <x-link :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-gray-800">
                        {{ __('Login') }}
                    </x-link>
                    <x-link :href="route('register')" class="text-sm font-medium text-gray-700 hover:text-gray-800">
                        {{ __('Register') }}
                    </x-link>
                @endauth
            </div>
        </div>
    @endif
</div> --}}
<div x-data="{ open: false }" class="relative lg:hidden w-full">
    <!-- Mobile Menu Button -->
    <button @click="open = !open" class="p-2 text-gray-600 hover:text-gray-800">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>

    <!-- Mobile Navigation -->
    <div x-show="open" x-transition 
        class="absolute top-full inset-x-0 mx-auto w-full max-w-md bg-white border border-gray-200 shadow-lg z-50 rounded-md"
        @click.away="open = false"
    >
        <div class="flex flex-col space-y-4 px-6 py-4">
            {{-- @foreach ($categories as $category)
                <x-nav.item :href="route('front.category', $category->slug)" 
                    class="block text-lg font-medium text-gray-700 hover:text-gray-900">
                    {{ $category->name }}
                </x-nav.item>
            @endforeach --}}

            @auth
                <livewire:components.account-menu />
            @else
                <x-link :href="route('login')" class="text-lg font-medium text-gray-700 hover:text-gray-900">
                    {{ __('Login') }}
                </x-link>
                <x-link :href="route('register')" class="text-lg font-medium text-gray-700 hover:text-gray-900">
                    {{ __('Register') }}
                </x-link>
            @endauth
        </div>
    </div>
</div>


