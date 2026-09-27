<?php

declare(strict_types=1);

use Vwork\Domain\IDomainRegistry;
use Vwork\Web\Controllers\AdminController;
use Vwork\Web\Controllers\AuthController;
use Vwork\Web\Controllers\CustomerController;
use Vwork\Web\Controllers\DummyController;
use Vwork\Web\Controllers\FrontDeskController;
use Vwork\Web\Controllers\SupervisorController;
use Vwork\Web\Controllers\TechnicianController;

/**
 * Every controller the app can route to, and how to build it.
 * Each is built once, the first time a route needs it.
 */
return [
    DummyController::class => static fn (IDomainRegistry $registry): DummyController => new DummyController(),
    AuthController::class => static fn (IDomainRegistry $registry): AuthController => new AuthController(),
    CustomerController::class => static fn (IDomainRegistry $registry): CustomerController => new CustomerController(),
    FrontDeskController::class => static fn (IDomainRegistry $registry): FrontDeskController => new FrontDeskController(),
    TechnicianController::class => static fn (IDomainRegistry $registry): TechnicianController => new TechnicianController(),
    SupervisorController::class => static fn (IDomainRegistry $registry): SupervisorController => new SupervisorController(),
    AdminController::class => static fn (IDomainRegistry $registry): AdminController => new AdminController(),
];
