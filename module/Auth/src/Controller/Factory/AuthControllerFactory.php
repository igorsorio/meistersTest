<?php
namespace Auth\Controller\Factory;

use Auth\Controller\AuthController;
use Interop\Container\ContainerInterface;


class AuthControllerFactory  {

    public function __invoke(ContainerInterface $containerInterface)
    {
        return new AuthController($containerInterface);
    }



}