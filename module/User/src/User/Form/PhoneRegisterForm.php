<?php

namespace User\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class PhoneRegisterForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('phone');

        $this->setHydrator(new DoctrineHydrator($objectManager));
        $phoneRegisterFormFieldset = new PhoneRegisterFieldset($objectManager);
        $phoneRegisterFormFieldset->setUseAsBaseFieldset(true);
        $phoneRegisterFormFieldset->setOptions(array(
            'label' => ' ',
        ));
        $this->add($phoneRegisterFormFieldset);
    }
}
