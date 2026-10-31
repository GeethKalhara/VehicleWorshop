<?php

declare(strict_types=1);

namespace Vwork\Web\Test\Stubs;

use Vwork\Shared\Collections\IRegistry;
use Vwork\Web\Controllers\ControllerBase;
use Vwork\Web\Http\Request\Request;

/**
 * ControllerBase's helpers are protected. This stub makes them public
 * so tests can call them directly.
 */
final readonly class ControllerBaseStub extends ControllerBase
{
    public function __construct(IRegistry $registry)
    {
        parent::__construct($registry);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function callView(Request $request, string $template, array $data = [], ?string $layout = null): string
    {
        return $this->view($request, $template, $data, $layout);
    }
}
