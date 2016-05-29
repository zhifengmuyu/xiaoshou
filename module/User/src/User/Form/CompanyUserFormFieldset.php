<?php
namespace User\Form;
 
use User\Entity\CompanyUser;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
 
class CompanyUserFormFieldset extends Fieldset implements InputFilterProviderInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        parent::__construct('profile');
 
        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new CompanyUser());
 
        $this->add(array(
            'name' => 'cu_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
            'options' => array(
                'label' => ' ',
            ),
        ));
 
        $this->add(array(
            'name' => 'cu_xref_u_id',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type'       => 'text',
            'name'       => 'u_email',
            'options'  => array(
                'label' => 'Email address: ',
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
            'type'       => 'text',
            'name'       => 'cu_name',
            'options'  => array(
                'label' => 'Nickname: ',
            ),
        )); 

        $this->add(array(
            'type'       => 'textarea',
            'name'       => 'cu_description',
            'options'  => array(
                'label' => 'Description: ',
            ),
        ));        

        $this->add(array(
            'type'       => 'text',
            'name'       => 'cu_fixed_phone',
            'options'  => array(
                'label' => 'Fixed phone: ',
            ),
        )); 

        $this->add(array(
            'type'       => 'text',
            'name'       => 'cu_location',
            'options'  => array(
                'label' => 'Location: ',
            ),
        )); 

        $this->add(array(
            'type'       => 'text',
            'name'       => 'cu_wechat',
            'options'  => array(
                'label' => 'Wechat: ',
            ),
        )); 

        $this->add(array(
            'type'       => 'text',
            'name'       => 'cu_labels',
            'options'  => array(
                'label' => 'Labels: ',
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
            'u_email' => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 2,
                                'max' => 100,
                             ),
                    ),
                    array(
                        'name' => 'EmailAddress',
                    ),
                    array(
                        'name' => 'User\Form\NoOtherEntityExists',
                        'options' => array(
                            'object_repository' => $this->objectManager->getRepository('User\Entity\User'),
                            'fields' => 'u_email',
                            'id' => $this->getObject()->getCuXrefUId(),
                            'id_getter' => 'getId',
                            'messages' => array(
                                'User\Form\NoOtherEntityExists'::ERROR_OBJECT_FOUND => "Email address '%value%' already exists",
                            ),
                        ),
                    ),
                ),
            ),

            'u_mobile_phone' => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 11,
                        ),
                    ),
                    array(
                        'name' => 'User\Form\NoOtherEntityExists',
                        'options' => array(
                            'object_repository' => $this->objectManager->getRepository('User\Entity\User'),
                            'fields' => 'u_mobile_phone',
                            'id' => $this->getObject()->getCuXrefUId(),
                            'id_getter' => 'getId',
                            'messages' => array(
                                'DoctrineModule\Validator\NoObjectExists'::ERROR_OBJECT_FOUND => "Phone number '%value%' already exists",
                            ),
                        ),
                    ),
                ),
            ),  


            'cu_name' => array(
                'required' => false,
            ),

            'cu_description' => array(
                'required' => false,
            ),

            'cu_fixed_phone' => array(
                'required' => false,
            ),  

            'cu_wechat' => array(
                'required' => false,
            ),  

            'cu_location' => array(
                'required' => false,
            ),

            'cu_labels' => array(
                'required' => false,
            ),
        );
    }
}
