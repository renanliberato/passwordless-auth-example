<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\Controller;

use PasswordlessAuth\Service\AuthService;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;

/**
 * Description of RegisterController
 *
 * @author renan
 */
class RegisterController extends AbstractActionController
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function registerAction()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->redirect()->toRoute('passwordless-auth', [
                        'controller' => 'register',
            ]);
        }

        $email = $this->params()->fromPost('email');
        $name = $this->params()->fromPost('name');

        $this->authService->register($email, $name);

        return $this->redirect()->toRoute('passwordless-auth', [
                    'controller' => 'validatetoken',
                        ], [
                    'query' => [
                        'email' => $email
                    ]
        ]);
    }

}
