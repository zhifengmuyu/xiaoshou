<?php
namespace User\Form;
 
use User\Entity\IndividualUser;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
 
class IndividualUserFormFieldset extends Fieldset implements InputFilterProviderInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        parent::__construct('profile');
 
        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new IndividualUser());
 
        $this->add(array(
            'name' => 'iu_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
            'options' => array(
                'label' => ' ',
            ),
        ));
 
        $this->add(array(
            'name' => 'iu_xref_u_id',
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
            'name'       => 'iu_nickname',
            'options'  => array(
                'label' => 'Nickname: ',
            ),
        )); 

        $this->add(array(
            'type'       => 'text',
            'name'       => 'iu_wechat',
            'options'  => array(
                'label' => 'Wechat: ',
            ),
        ));        

        $this->add(array(
            'type'       => 'text',
            'name'       => 'u_fixed_phone',
            'options'  => array(
                'label' => 'Fixed phone: ',
            ),
        )); 

        $this->add(array(
            'type'       => 'text',
            'name'       => 'iu_labels',
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
                            'id' => $this->getObject()->getIuXrefUId(),
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
                            'id' => $this->getObject()->getIuXrefUId(),
                            'id_getter' => 'getId',
                            'messages' => array(
                                'DoctrineModule\Validator\NoObjectExists'::ERROR_OBJECT_FOUND => "Phone number '%value%' already exists",
                            ),
                        ),
                    ),
                ),
            ),  


            'iu_nickname' => array(
                'required' => false,
            ),

            'iu_fixed_phone' => array(
                'required' => false,
            ),  

            'iu_wechat' => array(
                'required' => false,
            ),  

            'iu_labels' => array(
                'required' => false,
            ),
        );
    }
}
