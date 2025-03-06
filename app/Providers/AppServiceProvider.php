<?php

namespace App\Providers;

use App\Sidebar\BlogSidebar;
use Illuminate\Support\ServiceProvider;
use Shopper\Sidebar\SidebarBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app['events']->listen( SidebarBuilder::class, BlogSidebar::class); // [tl! focus]

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
