<?php

namespace Auth\Storage\Factory;

use Interop\Container\ContainerInterface;
use Auth\Storage\Authenticate;
use Auth\Storage\AuthStorage;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;

class AuthenticateFactory{

    private $containerInterface;

    function __invoke(ContainerInterface $containerInterface)
    {
        //$configAuth = $containerInterface->get('ZF_CONFIG');
        $dbAdapter = $containerInterface->get(AdapterInterface::class);
        $dbTableAuthAdapater = new AuthAdapter(
            $dbAdapter,
            'users',
            'email',
            'password',
        );

        $authService = new AuthenticationService();
        $authService->setAdapter($dbTableAuthAdapater);
        $authService->setStorage(new AuthStorage());
        return new Authenticate($authService);

    }
}