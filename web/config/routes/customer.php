<?php

declare(strict_types=1);

use Vwork\Web\Controllers\CustomerController;
use Vwork\Web\Http\HttpMethods;

return [
    [
        'method' => HttpMethods::GET,
        'path' => '/customer/dashboard',
        'controller' => ['class' => CustomerController::class, 'method' => 'dashboard'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/customer/vehicles',
        'controller' => ['class' => CustomerController::class, 'method' => 'vehicles'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/customer/appointments',
        'controller' => ['class' => CustomerController::class, 'method' => 'appointments'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/customer/service-history',
        'controller' => ['class' => CustomerController::class, 'method' => 'serviceHistory'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/customer/profile',
        'controller' => ['class' => CustomerController::class, 'method' => 'profile'],
        'middleware' => [],
        'context' => [],
    ],
];
