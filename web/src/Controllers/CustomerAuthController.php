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
    public function showLogin(Request $req, array $attr): Response
    {
        // -------------------------------------------------------------
        // When we have a DB later, we might check if user is already logged in:
        // if ($this->authService->isAuthenticated($req)) return Response::redirect('/customer/dashboard');
        // -------------------------------------------------------------


        return $this->view($req, 'Customer/login', [
            'title'             => 'Sign In - AutoCare Customer Portal',
            'actionUrl'         => '/customer/login',
            'signupUrl'         => '/customer/register',
            'forgotPasswordUrl' => '/customer/forgot-password',
            'contactUrl'        => '#',
            'error'             => null,
            'success'           => null,
            'mobile'            => null,
        ], 'layouts/auth');
    }

    /**
     * Renders the Customer Registration page (GET /customer/register)
     *
     * @param StringMap $attr
     */
    #[ControllerAction]
    public function showRegister(Request $req, array $attr): Response
    {
        return $this->view($req, 'Customer/register', [
            'title'             => 'Create Account - AutoCare Customer Portal',
            'actionUrl'         => '/customer/register',
            'loginUrl'          => '/customer/login',
            'contactUrl'        => '#',
            'error'             => null,
            'success'           => null,
            'old'               => [],
        ], 'layouts/auth');
    }

    /**
     * Alias for showRegister
     *
     * @param StringMap $attr
     */
    #[ControllerAction]
    public function showSignup(Request $req, array $attr): Response
    {
        return $this->showRegister($req, $attr);
    }
}
