<?php

namespace App\Providers;

use App\Http\Middleware\checkRole;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Configuration\Middleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}
