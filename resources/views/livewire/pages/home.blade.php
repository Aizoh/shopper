@push('customstyles')
<style>
    * {box-sizing: border-box;}
    body {font-family: Verdana, sans-serif;}
    .mySlides {display: none;}
    img {vertical-align: middle;}
    
    /* Slideshow container */
    .slideshow-container {
      max-width: 1000px;
      position: relative;
      margin: auto;
    }
    
    /* Caption text */
    .text {
      color: #f2f2f2;
      font-size: 15px;
      padding: 8px 12px;
      position: absolute;
      bottom: 8px;
      width: 100%;
      text-align: center;
    }
    
    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }
    
    /* The dots/bullets/indicators */
    .dot {
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }
    
    .active {
      background-color: #717171;
    }
    
    /* Fading animation */
    .fade {
      animation-name: fade;
      animation-duration: 1.5s;
    }
    
    @keyframes fade {
      from {opacity: .4} 
      to {opacity: 1}
    }
    
    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
      .text {font-size: 11px}
    }
    </style>
@endpush

<div class="relative isolate overflow-hidden">
    <livewire:product-search />

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

    <x-container class="relative py-16 sm:pt-24 lg:py-40 lg:flex lg:items-center lg:gap-x-10">
        <div class="sm:max-w-xl">
            <div>
                <h1 class="font font-heading text-4xl font-extrabold tracking-tight text-black sm:text-6xl">
                    {{ __('Best Sellers') }}
                </h1>
                <p class="mt-4 text-xl text-gray-500">
                    {{ __('We have in stock skincare products created in collaboration with dermatologists, our top-selling products are formulated with three essential ceramides to restore the skin/’s protective barrier, locking in moisture while keeping impurities out.
                    Infused with ingredients like hyaluronic acid, these products help retain hydration, leaving skin looking healthy and refreshed.
                    Explore our best-sellers or our full range of skincare solutions that match for your unique needs.') }}
                </p>
            </div>
            <div class="py-10">
                <x-buttons.primary href="#" class="group px-8 py-3 text-center text-base font-medium">
                    {{ __('Shop now') }}
                    <span
                        class="ml-2 translate-x-0 transform transition duration-200 ease-in-out group-hover:translate-x-1"
                    >
                        <x-untitledui-arrow-narrow-right class="size-6" stroke-width="1.5" aria-hidden="true" />
                    </span>
                </x-buttons.primary>
            </div>
        </div>
         
        <div class="mt-16 sm:mt-24 lg:mt-0 lg:shrink-0 lg:grow">
            <div class="slideshow-container">

                <div class="mySlides fade">
                  <div class="numbertext">1 / 3</div>
                  <img src="{{ asset('images/2br.png') }}" style="width:100%">
                  <div class="text">Caption Text</div>
                </div>
                
                <div class="mySlides fade">
                  <div class="numbertext">2 / 3</div>
                  <img src="{{ asset('images/3.jpg') }}"style="width:100%">
                  <div class="text">Caption Two</div>
                </div>
                
                <div class="mySlides fade">
                  <div class="numbertext">3 / 3</div>
                  <img src="{{ asset('images/1.jpg') }}" style="width:100%">
                  <div class="text">Caption Three</div>
                </div>
                
            </div>
                <br>
                
                <div style="text-align:center">
                  <span class="dot"></span> 
                  <span class="dot"></span> 
                  <span class="dot"></span> 
                </div>
            {{-- <img class="h-auto object-cover lg:max-w-3xl mx-auto" src="{{ asset('images/2br.png') }}" alt="" /> --}}
        </div>
        
   
    </x-container>

     <x-stats /> 

    <div class="bg-gray-50">
        <x-container class="py-16 lg:py-24">
            @if($collections->isNotEmpty())
                <section aria-labelledby="collection-heading" class="mx-auto max-w-xl lg:max-w-none">
                    <h2 id="collection-heading" class="font-heading text-2xl font-extrabold tracking-tight text-gray-950 sm:text-3xl">
                        {{ __('Shop by Collection') }}
                    </h2>
                    <p class="mt-2 text-base/6 max-w-3xl text-gray-500">
                        {{ __('Explore our curated furniture collections, designed to elevate every space. From modern minimalism to classic elegance, find timeless pieces that blend style, comfort, and functionality for your home.') }}
                    </p>

                    {{-- <div class="mt-10 space-y-12 lg:grid lg:grid-cols-3 lg:gap-x-8 lg:space-y-0">
                        @foreach($collections as $collection)
                            <x-link href="#" class="group block">
                                <img
                                    src="{{ $collection->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
                                    alt="{{ $collection->name }}"
                                    class="aspect-[3/2] w-full object-cover group-hover:opacity-75 lg:aspect-[3/2]"
                                />
                                <h3 class="mt-2 text-base font-semibold text-gray-900">
                                    {{ $collection->name }}
                                </h3>
                            </x-link>
                        @endforeach
                    </div> --}}
                    {{-- <div class="mt-10 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                        @foreach($collections as $collection)
                            <x-link href="#" class="group block">
                                <img
                                    src="{{ $collection->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
                                    alt="{{ $collection->name }}"
                                    class="aspect-[3/2] w-full object-cover group-hover:opacity-75"
                                />
                                <h3 class="mt-2 text-base font-semibold text-gray-900">
                                    {{ $collection->name }}
                                </h3>
                            </x-link>
                        @endforeach
                    </div> --}}
                    <div class="mt-10 overflow-x-auto scrollbar-hide">
                        <div class="flex gap-6 snap-x snap-mandatory scroll-pl-6">
                            @foreach($collections as $collection)
                                <x-link href="{{ route('single-collection', $collection->slug) }}" class="group block snap-start shrink-0 w-64">
                                    <img
                                        src="{{ $collection->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
                                        alt="{{ $collection->name }}"
                                        class="aspect-[3/2] w-full object-cover group-hover:opacity-75"
                                    />
                                    <h3 class="mt-2 text-base font-semibold text-gray-900">
                                        {{ $collection->name }}
                                    </h3>
                                </x-link>
                            @endforeach
                        </div>
                    </div>
                    
                    
                </section>
            @endif

            <section aria-labelledby="products-list" class="mt-16 max-w-3xl lg:mt-32 lg:max-w-none">
                <h2 class="font-heading text-2xl font-semibold tracking-tight text-gray-950 sm:text-3xl">
                    {{ __('Popular products') }}
                </h2>

                {{-- <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($products as $product)
                        <x-product.card :product="$product" />
                    @endforeach
                </div> --}}
                <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                    @foreach ($products as $product)
                        <x-product.card :product="$product" />
                    @endforeach
                </div>
                
            </section>
        </x-container>
    </div>
</div>
@push('customscripts')
<script>
    let slideIndex = 0;
    showSlides();
    
    function showSlides() {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
      }
      slideIndex++;
      if (slideIndex > slides.length) {slideIndex = 1}    
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
      setTimeout(showSlides, 5000); // Change image every 2 seconds
    }
    </script>
@endpush
