<?php

namespace App\Livewire;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopper\Livewire\Pages\AbstractPageComponent;

class CustomDashboard extends AbstractPageComponent
{
    public function render(): View
    {
        return view('livewire.custom-dashboard')
        
            ->title(__('shopper::pages/dashboard.menu'));
    }
}
