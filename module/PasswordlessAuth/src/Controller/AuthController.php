<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */
declare(strict_types=1);

namespace PasswordlessAuth\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use PasswordlessAuth\Service\AuthService;

class AuthController extends AbstractActionController
{
    private AuthService $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function indexAction()
    {
        if ($this->authService->isLoggedIn()) {
            return $this->redirect()->toRoute('home');
        }

        return new ViewModel();
    }

    public function loginAction()
    {
        if ($this->authService->isLoggedIn()) {
            return $this->redirect()->toRoute('home');
        }
        
        if ($this->request->getMethod() !== 'POST') {
            return $this->redirect()->toRoute('passwordless-auth', [
                        'controller' => 'auth',
            ]);
        }

        $email = $this->params()->fromPost('email');

        $this->authService->authenticate($email);

        return $this->redirect()->toRoute('passwordless-auth', [
                    'controller' => 'validatetoken',
                        ], [
                    'query' => [
                        'email' => $email
                    ]
        ]);
    }

    public function logoutAction()
    {
        if (!$this->authService->isLoggedIn()) {
            return $this->redirect()->toRoute('home');
        }
        
        $this->authService->logout();

        return $this->redirect()->toRoute('home');
    }

    public function validateAction()
    {
        if ($this->authService->isLoggedIn()) {
            return $this->redirect()->toRoute('home');
        }
        
        $token = $this->params()->fromQuery('token') ?? null;

        $this->authService->validateToken($token);

        return $this->redirect()->toRoute('home');
    }
}
