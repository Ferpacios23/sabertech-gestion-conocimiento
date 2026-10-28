<?php

namespace App\Providers;

use Illuminate\Support\Carbon;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fechas en español: "hace 2 días", "15 de octubre de 2026"
        Carbon::setLocale(config('app.locale'));
    }
}
