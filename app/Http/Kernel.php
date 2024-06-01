<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // protected $routeMiddleware = [
    //     'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    //     'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    //     'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    //     'can' => \Illuminate\Auth\Middleware\Authorize::class,
    //     'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    //     'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    // ];

    protected $routeMiddleware = [
        // 'jsonmiddleware' => \App\Http\Middleware\JsonMiddleware::class,
//        'api.key' => \App\Http\Middleware\ApiKeyMiddleware::class,
//        'cors' => \App\Http\Middleware\CorsMiddleware::class,
    ];
}
