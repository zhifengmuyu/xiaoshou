<?php

namespace User\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('login');

        $registerFormFieldset = new LoginFormFieldset();
        $registerFormFieldset->setUseAsBaseFieldset(true);
        $registerFormFieldset->setOptions(array(
            'label' => ' ',
        ));
        $this->add($registerFormFieldset);
    }
}
