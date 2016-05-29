<?php
namespace User\Form;
 
use User\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
 
class PhoneRegisterFieldset extends Fieldset implements InputFilterProviderInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        parent::__construct('phone');
 
        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new User());
 
        $this->add(array(
            'name' => 'u_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
            'options' => array(
                'label' => ' ',
            ),
        ));

         $this->add(array(
            'type'       => 'text',
            'name'       => 'u_mobile_phone',
            'options'  => array(
                'label' => 'Mobile phone: ',
            ),
        ));        
 
        $this->add(array(
            'name' => 'u_password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password: ',
            ),
        ));

        $this->add(array(
            'type'       => 'password',
            'name'       => 'passwordVerify',
            'options'    => array(
                'label' => 'Verify password: ',
            ),
        ));

         $this->add(array(
            'type'       => 'hidden',
            'name'       => 'u_creation',
            'options'  => array(
                'label' => 'Creation: ',
            ),
        ));        

         $this->add(array(
            'type'       => 'hidden',
            'name'       => 'u_deleted',
            'options'  => array(
                'label' => 'Deleted: ',
            ),
        ));   

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'value' => 'Submit',
                'id' => 'submitbutton',
            ),
        ));
    }
 
    /**
     * Define InputFilterSpecifications
     *
     * @access public
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'u_mobile_phone' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 11,
                        ),
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->objectManager->getRepository('User\Entity\User'),
                            'fields' => 'u_mobile_phone',
                            'messages' => array(
                                'DoctrineModule\Validator\NoObjectExists'::ERROR_OBJECT_FOUND => "Phone number '%value%' already exists",
                            ),
                        ),
                    ),
                ),
            ),  

            'u_password' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                        ),
                    ),
                ),
            ),

            'passwordVerify' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                        ),
                    ),
                    array(
                        'name'    => 'Identical',
                        'options' => array(
                            'token' => 'u_password',
                        ),
                    ),
                ),
            ),

            'u_creation' => array(
                'required' => false,
            ),  

            'u_deleted' => array(
                'required' => false,
            ),  
        );
    }
}
