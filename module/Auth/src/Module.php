<?php

namespace Auth;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Auth\Form\LoginFilter;
use Auth\Form\LoginForm;
use Auth\Form\Factory\LoginFilterFactory;
use Auth\Form\Factory\LoginFormFactory;
use Auth\Model\Users;
use Auth\Model\Factory\UsersFactory;
use Auth\Model\UsersTable;
use Auth\Model\Factory\UsersTableFactory;
use Auth\Storage\Authenticate;
use Auth\Storage\Factory\AuthenticateFactory;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Authenticate::class => AuthenticateFactory::class,
                LoginForm::class => LoginFormFactory::class,
                LoginFilter::class => LoginFilterFactory::class,
                Users::class => UsersFactory::class,
                UsersTable::class => UsersTableFactory::class,
            ]
            ];
    }

}
