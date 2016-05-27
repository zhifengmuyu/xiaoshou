<?php

namespace User\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class EmailRegisterForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('email');

        $this->setHydrator(new DoctrineHydrator($objectManager));
        $emailRegisterFormFieldset = new EmailRegisterFieldset($objectManager);
        $emailRegisterFormFieldset->setUseAsBaseFieldset(true);
        $emailRegisterFormFieldset->setOptions(array(
            'label' => ' ',
        ));
        $this->add($emailRegisterFormFieldset);
    }
}
