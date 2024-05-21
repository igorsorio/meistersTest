<?php

namespace Auth\Model\Factory;

use Interop\Container\ContainerInterface;
use Auth\Model\Users;

class UsersFactory{

    private $containerInterface;

    function __invoke(ContainerInterface $containerInterface)
    {
        return new Users();
    }
}