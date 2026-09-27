<?php

declare(strict_types=1);

namespace Vwork\Web\Controllers;

use Vwork\Web\Http\Request;
use Vwork\Web\Http\Response;

final class AdminController extends ControllerBase
{
    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function dashboard(Request $request, array $attributes): Response
    {
        return $this->view('admin/dashboard', [
            'pageTitle' => 'System Administration — VWMS',
            'staffName' => 'Samantha Perera',
        ]);
    }
}
