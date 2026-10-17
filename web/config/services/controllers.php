<?php

declare(strict_types=1);

use Vwork\Shared\Collections\IRegistry;
use Vwork\Web\Controllers\DummyController;
use Vwork\Web\Controllers\CustomerAuthController;

return [
    DummyController::class        => static fn (IRegistry $r): DummyController => new DummyController($r),
    CustomerAuthController::class => static fn (IRegistry $r): CustomerAuthController => new CustomerAuthController($r),
];
