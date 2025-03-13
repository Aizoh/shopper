<div class="bg-gray-50">
    <x-container class="py-3 lg:py-5">
    
        <section aria-labelledby="products-list" class=" max-w-3xl lg:mt-32 lg:max-w-none">
            <h2 class="font-heading text-2xl font-semibold tracking-tight text-gray-950 sm:text-3xl">
                {{ $collection->name}}
            </h2>

            {{-- <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @foreach ($products as $product)
                    <x-product.card :product="$product" />
                @endforeach
            </div> --}}
            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                @foreach ($collection->products as $product)
                    <x-product.card :product="$product" />
                @endforeach
            </div>
            
        </section>
    </x-container>
</div>