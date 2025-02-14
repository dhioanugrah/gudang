<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MutasiBarang;
use App\Observers\MutasiBarangObserver;

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
        MutasiBarang::observe(MutasiBarangObserver::class);
    }
}
