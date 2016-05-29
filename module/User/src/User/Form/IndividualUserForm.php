<?php

namespace User\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class IndividualUserForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('profile');

        $this->setHydrator(new DoctrineHydrator($objectManager));
        $userProfileFormFieldset = new IndividualUserFormFieldset($objectManager);
        $userProfileFormFieldset->setUseAsBaseFieldset(true);
        $userProfileFormFieldset->setOptions(array(
            'label' => ' ',
        ));
        $this->add($userProfileFormFieldset);
    }
}
