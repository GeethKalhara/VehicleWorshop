<?php

declare(strict_types=1);

use Vwork\Web\Controllers\AdminController;
use Vwork\Web\Controllers\FrontDeskController;
use Vwork\Web\Controllers\SupervisorController;
use Vwork\Web\Controllers\TechnicianController;
use Vwork\Web\Http\HttpMethods;

return [
    // Front Desk Routes
    [
        'method' => HttpMethods::GET,
        'path' => '/frontdesk/dashboard',
        'controller' => ['class' => FrontDeskController::class, 'method' => 'dashboard'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/frontdesk/active-jobs',
        'controller' => ['class' => FrontDeskController::class, 'method' => 'activeJobs'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/frontdesk/customers',
        'controller' => ['class' => FrontDeskController::class, 'method' => 'customers'],
        'middleware' => [],
        'context' => [],
    ],

    // Technician Workstation Routes
    [
        'method' => HttpMethods::GET,
        'path' => '/technician/workstation',
        'controller' => ['class' => TechnicianController::class, 'method' => 'workstation'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::GET,
        'path' => '/technician/job-history',
        'controller' => ['class' => TechnicianController::class, 'method' => 'jobHistory'],
        'middleware' => [],
        'context' => [],
    ],
    [
        'method' => HttpMethods::POST,
        'path' => '/technician/mark-qa',
        'controller' => ['class' => TechnicianController::class, 'method' => 'markQa'],
        'middleware' => [],
        'context' => [],
    ],

    // Supervisor Routes
    [
        'method' => HttpMethods::GET,
        'path' => '/supervisor/dashboard',
        'controller' => ['class' => SupervisorController::class, 'method' => 'dashboard'],
        'middleware' => [],
        'context' => [],
    ],

    // Admin Routes
    [
        'method' => HttpMethods::GET,
        'path' => '/admin/dashboard',
        'controller' => ['class' => AdminController::class, 'method' => 'dashboard'],
        'middleware' => [],
        'context' => [],
    ],
];
