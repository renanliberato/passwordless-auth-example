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

class NotesController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function createAction()
    {
        return $this->redirect()->toUrl('/notes');
    }
    
    public function updateAction()
    {
        return $this->redirect()->toUrl('/notes');
    }
    
    public function removeAction()
    {
        return $this->redirect()->toUrl('/notes');
    }
}
