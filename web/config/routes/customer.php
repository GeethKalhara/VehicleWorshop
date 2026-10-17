<?php

declare(strict_types=1);

use Vwork\Web\Controllers\CustomerAuthController;
use Vwork\Web\Http\HttpMethods;

return [
    [
        'method'     => HttpMethods::GET,
        'path'       => '/customer/login',
        'controller' => ['class' => CustomerAuthController::class, 'method' => 'showLogin'],
        'middleware' => [],
        'context'    => [],
    ],

    [
        'method'     => HttpMethods::GET,
        'path'       => '/customer/register',
        'controller' => ['class' => CustomerAuthController::class, 'method' => 'showSignup'],
        'middleware' => [],
        'context'    => [],
    ],
];
