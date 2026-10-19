<?php

declare(strict_types=1);

namespace Vwork\Web\Controllers;

use Vwork\Shared\Collections\IRegistry;
use Vwork\Web\Http\Request;
use Vwork\Web\Http\Response;

/**
 * Handles Customer authentication flows (Login, Register, Logout).
 *
 * @phpstan-import-type StringMap from IController
 */
final readonly class CustomerAuthController extends ControllerBase
{
    public function __construct(IRegistry $registry)
    {
        parent::__construct($registry);
    }

    /**
     * Renders the Customer Login page (GET /customer/login)
     *
     * @param StringMap $attr
     */
    #[ControllerAction]
    public function loginPage(Request $req, array $attr): Response
    {
        // -------------------------------------------------------------
        // When we have a DB later, we might check if user is already logged in:
        // if ($this->authService->isAuthenticated($req)) return Response::redirect('/customer/dashboard');
        // -------------------------------------------------------------

        return $this->renderLogin($req);
    }

    private function renderLogin(Request $req, ?string $error = null, ?string $success = null, string $mobile = ''): Response
    {
        return $this->view($req, 'customer/login', [
            'title'     => 'Sign In - AutoCare Customer Portal',
            'error'     => $error,
            'success'   => $success,
            'mobile'    => $mobile,
        ], 'layouts/auth');
    }

    /**
     * Renders the Customer Registration page (GET /customer/register)
     *
     * @param StringMap $attr
     */
    #[ControllerAction]
    public function registerPage(Request $req, array $attr): Response
    {
        return $this->renderRegister($req);
    }

    /**
     * @param array{
     *  first_name?: string,
     *  last_name?: string,
     *  mobile?: string,
     *  email?: string
     * } $old
     */
    private function renderRegister(Request $req, ?string $error = null, ?string $success = null, array $old = []): Response
    {
        return $this->view($req, 'customer/register', [
            'title'   => 'Create Account - AutoCare Customer Portal',
            'error'   => $error,
            'success' => $success,
            'old' => $old + array_fill_keys(['first_name', 'last_name', 'mobile', 'email'], ''),
        ], 'layouts/auth');
    }
}
