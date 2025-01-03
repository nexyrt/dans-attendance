<?php

namespace App\Providers;

use App\Livewire\Shared\CheckOutModal;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
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
        Blade::component('notification', \App\View\Components\Shared\Notification::class);
        Livewire::component('shared.check-out-modal', CheckOutModal::class);
        Livewire::component('shared.check-in-modal', \App\Livewire\Shared\CheckInModal::class);
    }
}
