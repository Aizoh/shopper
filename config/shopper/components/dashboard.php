<?php

declare(strict_types=1);

use Shopper\Livewire\Components;
use Shopper\Livewire\Pages;
use App\Livewire;
return [

    /*
    |--------------------------------------------------------------------------
    | Livewire Pages
    |--------------------------------------------------------------------------
    */

    'pages' => [
        // 'dashboard' => Pages\Dashboard::class,
        'dashboard' => App\Livewire\CustomDashboard::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire Components
    |--------------------------------------------------------------------------
    */

    'components' => [
        // 'search' => Components\Search::class,
        'side-panel' => Components\SlideOverPanel::class,
        'modal' => Components\Modal::class,
    ],

];
