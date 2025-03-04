<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Contracts\View\View;

use Laravelcm\LivewireSlideOvers\SlideOverComponent;


class ProductSearch extends SlideOverComponent
{
    // public $query = '';  // Search input
    // public $products = []; // Search results

    // public function updatedQuery()
    // {
    //     $this->products = Product::where('name', 'like', '%' . $this->query . '%')
    //         ->take(10) // Limit results
    //         ->get();
    // }

    public $query = '';
    public $products;
    public $suggestions;
    public $showModal = false;

    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    public function mount()
    {
        $this->products = collect(); // Initialize as a collection
        $this->suggestions = collect();
    }


    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->products = collect();
            $this->suggestions = collect();
            return;
        }

        // Fetch matching products
        $this->products = Product::where('name', 'like', "%{$this->query}%")
            ->take(10)
            ->get();

        // Fetch alternative suggestions if no exact match
        if ($this->products->isEmpty()) {
            $this->suggestions = Product::inRandomOrder()->take(5)->get();
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->query = '';
        $this->products = [];
        $this->suggestions = [];
    }
    public function toggleSearch()
    {
        $this->showModal = !$this->showModal;
    }
    public function render() : View
    {
        return view('livewire.product-search');
    }
}
