<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\JwtAuth;

class JwtAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registrar JwtAuth en el contenedor de servicios
        $this->app->singleton('JwtAuth', function ($app) {
            return new JwtAuth();
        });
    }

    public function boot(): void
    {
        //
    }
}
