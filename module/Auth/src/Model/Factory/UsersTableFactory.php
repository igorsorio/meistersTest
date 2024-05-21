<?php

namespace Auth\Model\Factory;

use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Auth\Model\Users;
use Auth\Model\UsersTable;

class UsersTableFactory{

    private $containerInterface;

    function __invoke(ContainerInterface $containerInterface)
    {
        $dbAdapter = $containerInterface->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($containerInterface->get(Users::class));
        return new UsersTable(new TableGateway('users', $dbAdapter, null, $resultSetPrototype));
    }
}