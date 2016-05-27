<?php

namespace User\Auth;

use DoctrineModule\Service\Authentication\AdapterFactory as BaseAdapterFactory;
use User\Auth\ObjectRepository;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdapterFactory extends BaseAdapterFactory
{
    /**
     * {@inheritDoc}
     *
     * @return \MyDoctrineAuth\Adapter\ObjectRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \DoctrineModule\Options\Authentication */
        $options = $this->getOptions($serviceLocator, 'authentication');
        if (is_string($objectManager = $options->getObjectManager())) {
            $options->setObjectManager($serviceLocator->get($objectManager));
        }
        return new ObjectRepository($options);
    }
}