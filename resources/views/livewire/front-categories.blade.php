<div class="relative isolate overflow-hidden">
    <svg
        class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
        aria-hidden="true"
    >
        <defs>
            <pattern
                id="0787a7c5-978c-4f66-83c7-11c213f99cb7"
                width="200"
                height="200"
                x="50%"
                y="-1"
                patternUnits="userSpaceOnUse"
            >
                <path d="M.5 200V.5H200" fill="none" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#0787a7c5-978c-4f66-83c7-11c213f99cb7)" />
    </svg>


    <div class="bg-gray-50">
        <x-container class="py-16 lg:py-24">
            @if($category->products->isNotEmpty())
            <section aria-labelledby="products-list" class="max-w-3xl  lg:max-w-none">
                <h2 class="font-heading text-2xl font-semibold tracking-tight text-gray-950 sm:text-3xl">
                    {{ $category->name }} Products
                </h2>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($category->products as $product)
                        <x-product.card :product="$product" />
                    @endforeach
                </div>
            </section>
            @endif

            @if($category->children->isNotEmpty())
                <section aria-labelledby="collection-heading" class="mt-10 mx-auto max-w-xl lg:mt-20 lg:max-w-none">
                    <h2 id="collection-heading" class="font-heading text-2xl font-extrabold tracking-tight text-gray-950 sm:text-3xl">
                        {{ $category->name }} > Subcategories
                    </h2>
                    <p class="mt-2 text-base/6 max-w-3xl text-gray-500">
                        Explore similar and related categories products here.
                    </p>

                    <div class="mt-10 space-y-12 lg:grid lg:grid-cols-3 lg:gap-x-8 lg:space-y-0">
                        @foreach($category->children as $child)
                            <x-link :href="route('front.category', $child->slug)" class="group block">
                                <img
                                    src="{{ $child->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
                                    alt="{{ $child->name }}"
                                    class="aspect-[3/2] w-full object-cover group-hover:opacity-75 lg:aspect-[3/2]"
                                />
                                <h3 class="mt-2 text-base font-semibold text-gray-900">
                                    {{ $child->name }}
                                </h3>
                                @if($child->products->count() > 0)
                                    <p class="mt-3 text-sm text-gray-500">
                                     + {{ $child->products->count() }} products and sub categories 
                                    </p>
                                @endif
                            </x-link>
                        @endforeach
                    </div>
                </section>
            @endif

            
        </x-container>
    </div>
</div>