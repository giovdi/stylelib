<?php

namespace Pixelstyle\Stylelib\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Pixelstyle\Stylelib\View\Components\Table;

class StyleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('stylelib-table', Table::class);
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'stylelib'); 
    }
}
