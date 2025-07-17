<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\CheckUserRole;

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
    public function boot(Middleware $middleware): void
    {
        $middleware->alias([
            'checkUserRole'=>CheckUserRole::class,
        ]);
    }
}
