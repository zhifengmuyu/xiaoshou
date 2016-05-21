<?php

namespace User\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class RegisterForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('register');

        $this->setHydrator(new DoctrineHydrator($objectManager));
        $registerFormFieldset = new RegisterFormFieldset($objectManager);
        $registerFormFieldset->setUseAsBaseFieldset(true);
        $registerFormFieldset->setOptions(array(
            'label' => ' ',
        ));
        $this->add($registerFormFieldset);
    }
}
