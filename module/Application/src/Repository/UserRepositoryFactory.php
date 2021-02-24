<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Repository;

/**
 * Description of AuthServiceFactory
 *
 * @author renan
 */
class UserRepositoryFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        $connection = $container->get(\Application\Db\Connection::class);
        
        return new UserRepository($connection);
    }

}
