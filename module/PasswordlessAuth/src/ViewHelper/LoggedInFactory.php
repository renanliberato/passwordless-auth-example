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
class LoggedInFactory
{
    public function __invoke($container)
    {
        return new LoggedIn($container->get(AuthService::class));
    }

}
