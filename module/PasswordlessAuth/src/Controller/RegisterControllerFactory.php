<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\Controller;

/**
 * Description of IndexControllerFactory
 *
 * @author renan
 */
class RegisterControllerFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    //put your code here
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        return new RegisterController(
        $container->get(\PasswordlessAuth\Service\AuthService::class)
        );
    }

}
