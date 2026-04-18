<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Share clinic profile globally
        if (!app()->runningInConsole()) {
            try {
                \Illuminate\Support\Facades\View::share('clinicProfile', \App\Models\ClinicProfile::first());
            } catch (\Exception $e) {
                // Ignore if table doesn't exist yet
            }
        }
    }
}
