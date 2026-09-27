<?php

declare(strict_types=1);

namespace Vwork\Web\Controllers;

use Vwork\Web\Http\Request;
use Vwork\Web\Http\Response;

final class AuthController extends ControllerBase
{
    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function showCustomerLogin(Request $request, array $attributes): Response
    {
        return $this->view('auth/customer_login', ['pageTitle' => 'Customer Login — VWMS']);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function showCustomerRegister(Request $request, array $attributes): Response
    {
        return $this->view('auth/customer_register', ['pageTitle' => 'Create Account — VWMS']);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function showStaffLogin(Request $request, array $attributes): Response
    {
        return $this->view('auth/staff_login', ['pageTitle' => 'Staff Terminal Sign In — VWMS']);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function showForgotPassword(Request $request, array $attributes): Response
    {
        return $this->view('auth/forgot_password', ['pageTitle' => 'Forgot Password — VWMS']);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function showOtpVerify(Request $request, array $attributes): Response
    {
        return $this->view('auth/otp_verify', ['pageTitle' => 'OTP Verification — VWMS']);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function showOtpSuccess(Request $request, array $attributes): Response
    {
        return $this->view('auth/otp_success', ['pageTitle' => 'Verification Successful — VWMS']);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function showResetPassword(Request $request, array $attributes): Response
    {
        return $this->view('auth/reset_password', ['pageTitle' => 'Reset Password — VWMS']);
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function handleCustomerLogin(Request $request, array $attributes): Response
    {
        return Response::redirect('/customer/dashboard');
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function handleCustomerRegister(Request $request, array $attributes): Response
    {
        return Response::redirect('/customer/dashboard');
    }

    /** @param array<string, mixed> $attributes */
    #[ControllerAction]
    public function handleStaffLogin(Request $request, array $attributes): Response
    {
        return Response::redirect('/frontdesk/dashboard');
    }
}
