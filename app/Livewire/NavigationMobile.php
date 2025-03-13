<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class NavigationMobile extends Component
{
    public bool $isOpen = false;  // State for menu visibility

    public function toggleMenu()
    {
        $this->isOpen = !$this->isOpen;
    }
    public function render()
    {
        return view('livewire.navigation-mobile', [
            'categories' => Category::isRoot()->scopes(['enabled'])->get(),

        ]);
    }
}
