<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.templates.app')]

class SingleCollection extends Component
{
    public ?Collection $collection = null;

    public function mount(string $slug): void
    {
        $collection = Collection::with([
            'media',                       
            'products'
        ])
            //->withCount('descendants')
            ->where('slug', $slug)
            ->firstOrFail();

         //abort_unless($collection->is_enabled, 404);

        $this->collection = $collection;
        //dd($collection);
    }

    public function render(): View
    {
        return view('livewire.pages.single-collection')
        ->title($this->collection->name);
    }
}
