<?php

namespace Auth\Controller;

use Auth\Model\UsersTable;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\Placeholder\Container;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    private $containerInterface;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

    public function indexAction()
    {
        $users = $this->containerInterface->get(UsersTable::class);
        
        $this->layout('layout/auth');
        return new ViewModel([
            'users' => $users->fetchAll(),
        ]);
    }


}
