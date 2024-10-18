<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class JwtAuthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        // El alias que utilizaste al registrar el servicio
        return 'JwtAuth';
    }
}
