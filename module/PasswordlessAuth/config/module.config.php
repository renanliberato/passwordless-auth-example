<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace PasswordlessAuth;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'passwordless-auth' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/passwordless-auth[/:controller[/:action]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'auth' => Controller\AuthController::class,
            'register' => Controller\RegisterController::class,
            'validatetoken' => Controller\ValidateTokenController::class,
        ],
        'factories' => [
            Controller\AuthController::class => Controller\AuthControllerFactory::class,
            Controller\RegisterController::class => Controller\RegisterControllerFactory::class,
            Controller\ValidateTokenController::class => Controller\ValidateTokenControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Db\Connection::class => Db\ConnectionFactory::class,
            Service\AuthService::class => Service\AuthServiceFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'isLoggedIn' => ViewHelper\LoggedIn::class,
        ],
        'factories' => [
            ViewHelper\LoggedIn::class => ViewHelper\LoggedInFactory::class
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'passwordless-auth/index/index' => __DIR__ . '/../view/passwordless-auth/index/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
