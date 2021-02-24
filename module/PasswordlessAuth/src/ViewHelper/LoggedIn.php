<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\ViewHelper;

use PasswordlessAuth\Service\AuthService;

/**
 * Description of LoggedIn
 *
 * @author renan
 */
class LoggedIn extends \Laminas\View\Helper\AbstractHelper
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke()
    {
        return $this->authService->isLoggedIn();
    }

}
