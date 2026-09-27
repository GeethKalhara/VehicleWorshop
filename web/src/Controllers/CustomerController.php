<?php

declare(strict_types=1);

namespace Vwork\Web\Controllers;

use Vwork\Web\Http\Request;
use Vwork\Web\Http\Response;

final class CustomerController extends ControllerBase
{
    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function dashboard(Request $request, array $attributes): Response
    {
        return $this->view('customer/dashboard', [
            'pageTitle' => 'Customer Overview — VWMS',
            'customerName' => 'Kasun Perera',
            'vehicles' => [
                ['license_plate' => 'WP CBA-4321', 'make_model' => 'Toyota Axio 2018', 'mileage' => '45,200 km'],
                ['license_plate' => 'WP CAB-7892', 'make_model' => 'Toyota Prado 2020', 'mileage' => '62,800 km'],
            ],
            'activeRepairsCount' => 1,
            'nextServiceDate' => 'Oct 12, 2026',
        ]);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function vehicles(Request $request, array $attributes): Response
    {
        return $this->view('customer/vehicles', [
            'pageTitle' => 'My Vehicles — VWMS',
            'customerName' => 'Kasun Perera',
            'vehicles' => [
                ['license_plate' => 'WP CBA-4321', 'make_model' => '2018 Toyota Axio', 'vin' => 'NKE165-71024', 'mileage' => '45,200 km'],
                ['license_plate' => 'WP CAB-7892', 'make_model' => 'Toyota Prado GDJ150', 'vin' => 'GDJ150-00812', 'mileage' => '62,800 km'],
            ],
        ]);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function appointments(Request $request, array $attributes): Response
    {
        return $this->view('customer/appointments', [
            'pageTitle' => 'Service Appointments — VWMS',
            'customerName' => 'Kasun Perera',
        ]);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function serviceHistory(Request $request, array $attributes): Response
    {
        return $this->view('customer/service_history', [
            'pageTitle' => 'Service History — VWMS',
            'customerName' => 'Kasun Perera',
        ]);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function profile(Request $request, array $attributes): Response
    {
        return $this->view('customer/profile', [
            'pageTitle' => 'My Profile — VWMS',
            'customerName' => 'Kasun Perera',
        ]);
    }
}
