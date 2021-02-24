<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Http;

/**
 * Description of AppRequest
 *
 * @author renan
 */
class AppRequestFactory
{
    public function __invoke($container)
    {
        $config = $container->get('config');
        $request = new \Laminas\Http\PhpEnvironment\Request();
        $request->setBasePath($config['base_url']);
        $request->setBaseUrl($config['base_url']);
        
        return $request;
    }

}
