<?php

declare(strict_types=1);

use App\Models\Category;
use function Livewire\Volt\state;

state([
    'categories' => once(
        fn () => Category::isRoot()->scopes(['enabled'])->get()
    ),
]);
// state([
//     'categories' => once(
//         fn () => Category::root()->enabled()->get()
//     ),
    

// ]);

?>
@push('customstyles')
<style>
    * {
      box-sizing: border-box;
    }
    
    .navbar {
      overflow: hidden;
      background-color: #333;
      font-family: Arial, Helvetica, sans-serif;
    }
    
    .navbar a {
      float: left;
      font-size: 16px;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }
    
    .dropdown {
      float: left;
      overflow: hidden;
    }
    
    .dropdown .dropbtn {
      font-size: 16px;  
      border: none;
      outline: none;
      color: white;
      padding: auto;
      background-color: inherit;
      font: inherit;
      margin: 0;
    }
    
    .navbar a:hover, .dropdown:hover .dropbtn {
      background-color: primary;
    }
    
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      width: 100%;
      left: 0;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }
    
    .dropdown-content .header {
      background: red;
      padding: 16px;
      color: white;
    }
    
    .dropdown:hover .dropdown-content {
      display: block;
    }
    
    /* Create three equal columns that floats next to each other */
    .column {
      float: left;
      width: 33.33%;
      padding: 10px;
      background-color: #ccc;
      height: 250px;
    }
    
    .column a {
      float: none;
      color: black;
      padding: 16px;
      text-decoration: none;
      display: block;
      text-align: left;
    }
    
    .column a:hover {
      background-color: #ddd;
    }
    
    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    
    /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
      .column {
        width: 100%;
        height: auto;
      }
    }
    </style>
@endpush
{{-- <div class="hidden items-center gap-x-6 lg:flex">
    @foreach ($categories as $category)
        <x-nav.item :href="route('front.category', $category->slug)">{{ $category->name }}</x-nav.item>
    @endforeach
</div> --}}
{{-- {{ dd($categories) }} --}}
<div class="navbar">
    
    <div class="dropdown">
      {{-- <button class="dropbtn">Categories 
        <i class="fa fa-caret-down"></i>
      </button> --}}
      <x-buttons.primary class="group px-8 py-3 text-center text-base font-medium">
        Categories
        <span
            class="ml-2 translate-x-0 transform transition duration-200 ease-in-out group-hover:translate-x-1"
        >
            <x-untitledui-arrow-narrow-down class="size-6" stroke-width="1.5" aria-hidden="true" />
        </span>
    </x-buttons.primary>
   
      <div class="dropdown-content">
       
        <div class="row">
            @foreach ( $categories as $category)
            <div class="column">
                {{-- <h3>{{ $category->name }} </h3> --}}
                <h3><x-nav.item :href="route('front.category', $category->slug)">{{ $category->name }}</x-nav.item></h3>
                @foreach ( $category->children as $subcategory )
                    <a href="{{ route('front.category', $subcategory->slug) }}">{{ $subcategory->name }}</a>
                @endforeach
                
                
            </div>
            @endforeach
          
          {{-- <div class="column">
            <h3>Category 2</h3>
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
          </div>
          <div class="column">
            <h3>Category 3</h3>
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
          </div> --}}
        </div>
      </div>
    </div> 
  </div>
