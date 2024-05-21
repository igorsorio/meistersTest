<?php

namespace Auth\Storage;

use Zend\Authentication\AuthenticationService;
//use Zend\Session\Container;

class Authenticate 
{
        private $authenticationService;

        public function __construct(AuthenticationService $authenticationService) {
            $this->authenticationService = $authenticationService;
        }

        public function login($identity, $credencial) 
        {
            //$user_session = new Container('user');
            $this->getAuthService()->getAdapter()->setIdentity($identity)->setCredential($credencial);
            $result = $this->getAuthService()->authenticate();
            if($result->isValid()) {
                $omitPassword = ['password'];
                $user = $this->getAuthService()->getAdapter()->getResultRowObject(null, $omitPassword);
                //$user->ip_address = $ip_address;
                //$user->user_agent = $user_agent;
                $this->storeIdentity($user);
            }
            return $result;
        }

        public function logout()
        {
            $this->getAuthService()->getStorage()->clear();
        }

        public function hasIdentity()
        {
            $this->getAuthService()->getStorage()->read();
        }

        public function storeIdentity($identity)
        {
            $this->getAuthService()->getStorage()->write($identity);
        }

        public function getAuthService()
        {
            return $this->authenticationService;
        }

        public function toArray()
        {
            $hydraty = json_encode($this->hasIdentity());
            return json_decode($hydraty, true);
        }

}
 