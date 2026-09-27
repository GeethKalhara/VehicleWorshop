<?php

declare(strict_types=1);

namespace Vwork\Web\Controllers;

use Vwork\Web\Http\Request;
use Vwork\Web\Http\Response;

final class TechnicianController extends ControllerBase
{
    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function workstation(Request $request, array $attributes): Response
    {
        return $this->view('technician/workstation', [
            'pageTitle' => 'Tech Workstation — VWMS',
            'staffName' => 'Dishan Gamage',
        ]);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function jobHistory(Request $request, array $attributes): Response
    {
        return $this->view('technician/job_history', [
            'pageTitle' => 'Completed Jobs — VWMS',
            'staffName' => 'Dishan Gamage',
        ]);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function markQa(Request $request, array $attributes): Response
    {
        return Response::redirect('/technician/workstation');
    }
}
