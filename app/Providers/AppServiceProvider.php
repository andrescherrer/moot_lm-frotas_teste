<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Livewire\ProductSearch;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Livewire::component('product-search', ProductSearch::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination::tailwind');
    
        Paginator::defaultSimpleView('pagination::simple-tailwind');

        \Livewire\Livewire::forceAssetInjection();
    }
}
