<?php

namespace Channel\Factory;

use Channel\Controller\ChannelController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ChannelControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) 
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $userService = $realServiceLocator->get('User\Service\UserServiceInterface');

        return new ChannelController($userService);
    }
}
