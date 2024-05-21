<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRoutListener = new ModuleRouteListener();
        $moduleRoutListener->attach($eventManager);

        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e)
        {

            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            $action = $e->getRouteMatch()->getParam('action');            
            if (isset($config['modules_layouts'][$action])) {
                $controller->layout($config['modules_layouts'][$action]);
            } elseif (isset($config['modules_layouts'][$moduleNamespace])) {
                $controller->layout($config['modules_layouts'][$moduleNamespace]);
            }
        } , 100);
        
    }
}
