<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Db;

/**
 * Description of ConnectionFactory
 *
 * @author renan
 */
class ConnectionFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    //put your code here
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        $config = $container->get('config')['db'];
        
        return Connection::get($config['host'], $config['db'], $config['user'], $config['pass'], $config['charset']);
    }
}
