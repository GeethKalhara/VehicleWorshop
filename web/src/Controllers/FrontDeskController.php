<?php

declare(strict_types=1);

namespace Vwork\Web\Controllers;

use Vwork\Web\Http\Request;
use Vwork\Web\Http\Response;

final class FrontDeskController extends ControllerBase
{
    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function dashboard(Request $request, array $attributes): Response
    {
        return $this->view('frontdesk/dashboard', [
            'pageTitle' => 'Front Desk Intake — VWMS',
            'staffName' => 'Saman Kumara',
        ]);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function activeJobs(Request $request, array $attributes): Response
    {
        return $this->view('frontdesk/active_jobs', [
            'pageTitle' => 'Active Workshop Jobs — VWMS',
            'staffName' => 'Saman Kumara',
        ]);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function customers(Request $request, array $attributes): Response
    {
        return $this->view('frontdesk/customers', [
            'pageTitle' => 'Customer Directory — VWMS',
            'staffName' => 'Saman Kumara',
        ]);
    }
}
