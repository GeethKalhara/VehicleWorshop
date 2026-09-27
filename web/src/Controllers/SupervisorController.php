<?php

declare(strict_types=1);

namespace Vwork\Web\Controllers;

use Vwork\Web\Http\Request;
use Vwork\Web\Http\Response;

final class SupervisorController extends ControllerBase
{
    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function dashboard(Request $request, array $attributes): Response
    {
        return $this->view('supervisor/dashboard', [
            'pageTitle' => 'QA Inspection & Floor Approval — VWMS',
            'staffName' => 'Asanka Weerasinghe',
        ]);
    }
}
