<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Collection;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;


#[Layout('components.layouts.templates.app')]

class FrontCategories extends Component
{

    public ?Category $category = null;

    public function mount(string $slug): void
    {
        $category = category::with([
            'media',           
            'children',
            'siblings',
            'descendants',
            'products'
        ])
            ->withCount('descendants')
            ->where('slug', $slug)
            ->firstOrFail();

         abort_unless($category->is_enabled, 404);

        $this->category = $category;
       // dd($category);
    }


    public function render(): View
    {
        return view('livewire.front-categories', [

        
            
        ]);
    }
}
