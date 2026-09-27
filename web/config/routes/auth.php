<?php

declare(strict_types=1);

use Vwork\Web\Controllers\AuthController;
use Vwork\Web\Http\HttpMethods;

return [
    [
        'method' => HttpMethods::GET,
        'path' => '/',
        'controller' => ['class' => AuthController::class, 'method' => 'showCustomerLogin'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/login',
        'controller' => ['class' => AuthController::class, 'method' => 'showCustomerLogin'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::POST,
        'path' => '/login',
        'controller' => ['class' => AuthController::class, 'method' => 'handleCustomerLogin'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/register',
        'controller' => ['class' => AuthController::class, 'method' => 'showCustomerRegister'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::POST,
        'path' => '/register',
        'controller' => ['class' => AuthController::class, 'method' => 'handleCustomerRegister'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/staff/login',
        'controller' => ['class' => AuthController::class, 'method' => 'showStaffLogin'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::POST,
        'path' => '/staff/login',
        'controller' => ['class' => AuthController::class, 'method' => 'handleStaffLogin'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/forgot-password',
        'controller' => ['class' => AuthController::class, 'method' => 'showForgotPassword'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/otp-verify',
        'controller' => ['class' => AuthController::class, 'method' => 'showOtpVerify'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/otp-success',
        'controller' => ['class' => AuthController::class, 'method' => 'showOtpSuccess'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/reset-password',
        'controller' => ['class' => AuthController::class, 'method' => 'showResetPassword'],
        'middleware' => [],
        'context' => [],
    ],
];
