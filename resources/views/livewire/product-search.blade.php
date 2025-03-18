

<div>
    <div class="flex lg:ml-6">
    
        <button type="button" class="p-2 text-gray-400 hover:text-gray-500"  wire:click="toggleSearch">
            <span class="sr-only">{{ __('Recherche') }}</span>
            <svg
                class="size-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
        </button>
        
    </div>
    @if ($showModal)        
        <div class="flex flex-col w-full h-full divide-y divide-gray-200">
            <div class="flex-1 h-0 py-6 overflow-y-auto">
                <header class="px-4 sm:px-6">
                    <div class="flex items-start justify-between">
                        {{-- <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Search') }}
                        </h2> --}}
                        <div class="relative mb-4">
                            <input 
                                type="text" 
                                wire:model.live="query" 
                                placeholder="Search for products..." 
                                class="w-full px-4 py-2 text-gray-900 border border-gray-300 rounded-md focus:ring focus:ring-primary-500 focus:outline-none"
                            />
                        </div>
                        <div class="flex items-center ml-3 h-7">
                            <button
                                type="button"
                                class="text-gray-400 bg-white rounded-md hover:text-gray-500"
                                wire:click="toggleSearch"
                            >
                                <span class="sr-only">Close panel</span>
                                <x-untitledui-x class="size-6" stroke-width="1.5" aria-hidden="true" />
                            </button>
                        </div>
                    </div>
                </header>
        
                <div class="flex-1 px-4 mt-8 sm:px-6">
                    @if ($products->isNotempty())
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                {{-- @foreach ($products as $product)
                                    <x-cart.item wire:key="{{ $product->id }}" :item="$product" />
                                @endforeach --}}
                                @foreach($products as $product)
                            <li class="px-4 py-2 cursor-pointer hover:bg-gray-200">
                                <img class="w-16 h-16 rounded-md" 
                                                        src="{{ $product->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
                                                        alt="{{ $product->name }} thumbnail"
                                                        class="h-full w-full object-cover"
                                                    />
                                <x-link :href="route('single-product', $product->slug)">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $product->name }}
                                </x-link>
                            </li>
                            @endforeach
                            </ul>
                        </div>
                        @elseif ($suggestions->isNotEmpty())

                        <div class="space-y-5 text-center">
                            
                                
                                <div class="text-center">
                                    <h1 class="text-2xl font-semibold text-gray-900 font-heading">
                                        {{ __('No results found') }}
                                    </h1>
                                    <p class="mt-2 text-gray-500">
                                        {{ __('Try searching for something else or explore these suggestions.') }}
                                    </p>
                                </div>
            
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        @foreach ($suggestions as $suggested)
                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    
                                                    <img class="w-16 h-16 rounded-md" 
                                                        src="{{ $suggested->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
                                                        alt="{{ $suggested->name }} thumbnail"
                                                        class="h-full w-full object-cover"
                                                    />
                                                    <div>
                                                        <h3 class="text-lg font-medium text-gray-900">{{ $suggested->name }}</h3>
                                                        <p class="text-sm text-gray-500">{{ $suggested->price }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            
                        </div>
                        @else
                        <div class="space-y-5 text-center">
                            
                            <div class="text-center">
                                
                                <p class="mt-2 text-gray-500">
                                    {{ __('What are you shopping today?') }}
                                </p>
                            </div>
        
                           
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    @endif
</div>


