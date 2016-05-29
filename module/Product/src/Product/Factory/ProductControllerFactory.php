<?php

namespace Product\Factory;

use Product\Controller\ProductController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProductControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) 
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $userService = $realServiceLocator->get('User\Service\UserServiceInterface');

        return new UserController($userService);
    }
}
