<?php

namespace Auth\Controller;

use Auth\Model\UsersTable;
use Auth\Form\LoginForm;
use Auth\Storage\Authenticate;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Db\Adapter\Adapter;


//use Zend\Session\Container;


class LoginController extends AbstractActionController
{
    private $containerInterface;
    protected $authenticate;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

    public function getAuthenticate() 
    {
        $this->authenticate = $this->containerInterface->get(Authenticate::class);
        return $this->authenticate;
    }

    public function loginAction()
    {
        
        $auth = $this->getAuthenticate();
        if($auth->hasIdentity()) {
            return $this->redirect()->toRoute('task');
        }

        //$form = $this->containerInterface->get(LoginForm::class);
        $options = [];
        $form = new LoginForm($this->containerInterface, 'login', $options);

        
        if($this->params()->fromPost()) {
            $form->setData($this->params()->fromPost());
            if($form->isValid()){
                $dataForm = $form->getData();
                $result = $auth->login($dataForm['email'], md5($dataForm['password']));
                $messageResult = new Result($result->getCode(), $result->getIdentity());
                if($result->isValid()) {
                    $request['message'] = $messageResult->getMessages();
                    $request['success'] = $result->getCode();
                    return $this->redirect()->toRoute('task');
                } 
            }
        }

        return new ViewModel(compact('form'));
    }
    

    
    public function logoutAction()
    {
        if($this->getAuthenticate()->hasIdentity()) {
            $this->getAuthenticate()->logout();
        }
        return $this->redirect()->toRoute('auth');
    }

}
