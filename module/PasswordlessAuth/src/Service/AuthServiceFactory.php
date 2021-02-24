<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\Service;

/**
 * Description of AuthServiceFactory
 *
 * @author renan
 */
class AuthServiceFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        $userRepository = $container->get(\PasswordlessAuth\Repository\UserRepositoryInterface::class);
        $sessionRepository = $container->get(\PasswordlessAuth\Repository\SessionRepositoryInterface::class);
        $config = $container->get('config')['mail'];
        
        $transport = new \Laminas\Mail\Transport\Smtp();
        $options = new \Laminas\Mail\Transport\SmtpOptions($config);
        $transport->setOptions($options);
        
        return new AuthService($userRepository, $sessionRepository, $transport);
    }

}
