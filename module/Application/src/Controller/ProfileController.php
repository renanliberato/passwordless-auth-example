<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */
declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use PasswordlessAuth\Service\AuthService;

class ProfileController extends AbstractActionController
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function indexAction()
    {
        return new ViewModel([
            'sessions' => $this->authService->getSessions()
        ]);
    }

    public function disconnectAction()
    {
        $this->authService->disconnect($this->params()->fromPost('access_token'));

        return $this->redirect()->toRoute('application', ['controller' => 'profile']);
    }

    public function onDispatch(\Laminas\Mvc\MvcEvent $e)
    {
        $authService = $e->getApplication()->getServiceManager()->get(\PasswordlessAuth\Service\AuthService::class);

        if (!$authService->isLoggedIn()) {
            return $this->redirect()->toRoute('passwordless-auth', [
                        'controller' => 'auth'
            ]);
        }

        return parent::onDispatch($e);
    }

}
