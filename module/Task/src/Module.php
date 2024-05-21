<?php

namespace Task;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Task\Controller\TaskController;
use Task\Model\TaskTable;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
                Model\TaskTable::class => function($container) {
                    $tableGateway = $container->get(Model\TaskTableGateway::class);
                    return new Model\TaskTable($tableGateway);
                },
                Model\TaskTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Task());
                    return new TableGateway('tasks', $dbAdapter, null, $resultSetPrototype);
                },
                
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                TaskController::class => function($container) {
                    $taskGateway = $container->get(TaskTable::class);
                    return new TaskController($taskGateway);
                },
            ]
        ];
    }

    
}
