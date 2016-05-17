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
        $registerFormFieldset->remove('id');
        $registerFormFieldset->setUseAsBaseFieldset(true);
        $registerFormFieldset->setOptions(array(
            'label' => ' ',
        ));
        $this->add($registerFormFieldset);

        //$this->setAttribute('method', 'post');

        //$entity = new Users();
        //$builder = new AnnotationBuilder();
        //$this->add($builder->createForm($entity));


        //$this->add(array(
        //    'type'      => 'psssword',
        //    'name'       => 'passwordVerify',
        //    'required'   => true,
        //    'filters'    => array(array('name' => 'StringTrim')),
        //    'options'    => array(
        //        'label' => 'Verify password: ',
        //    ),
        //    'validators' => array(
        //        array(
        //            'name'    => 'StringLength',
        //            'options' => array(
        //                'min' => 6,
        //            ),
        //        ),
        //        array(
        //            'name'    => 'Identical',
        //            'options' => array(
        //                'token' => 'password',
        //            ),
        //        ),
        //    ),
        //));
        //$this->add(array(
        //    'name' => 'submit',
        //    'type' => 'Submit',
        //    'options' => array(
        //        'label' => 'test',
        //    ),
        //    'attributes' => array(
        //        'value' => 'Submit',
        //        'id' => 'submitbutton',
        //    ),
        //));
        //\Zend\Debug\Debug::dump($this->get('email'));

    }

    public function addFields()
    {
        
    }
}
