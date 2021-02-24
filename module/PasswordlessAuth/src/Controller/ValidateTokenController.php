<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use PasswordlessAuth\Service\AuthService;

/**
 * Description of ValidateTokenController
 *
 * @author renan
 */
class ValidateTokenController extends AbstractActionController
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function indexAction()
    {
        return new ViewModel([
            'email' => $this->params()->fromQuery('email')
        ]);
    }
    
    public function validateAction() {
        $this->authService->validateToken(
            $this->params()->fromPost('email'),
            $this->params()->fromPost('token')
        );
        
        return $this->redirect()->toRoute('home');
    }
}
