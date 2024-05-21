<?php
/**
 * Global Configuration Override
 */

return [
    'modules_layouts' => [
        'Auth' => 'layout/auth',
        'login' => 'layout/login'
    ],
    'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdpterServiceFactory',
];
