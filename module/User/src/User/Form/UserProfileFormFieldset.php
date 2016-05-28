<?php
namespace User\Form;
 
use User\Entity\Users;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
 
class userProfileFormFieldset extends Fieldset implements InputFilterProviderInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        parent::__construct('profile');
 
        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Users());
 
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
            'name' => 'u_email',
            'type' => 'text',
            'options' => array(
                'label' => 'Email: ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));
 
        $this->add(array(
            'type'       => 'text',
            'name'       => 'u_nickname',
            'options'  => array(
                'label' => 'Nickname: ',
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
            'name'       => 'u_fixed_phone',
            'options'  => array(
                'label' => 'Fixed phone: ',
            ),
        )); 

        $this->add(array(
            'type'       => 'text',
            'name'       => 'u_wechat',
            'options'  => array(
                'label' => 'Wechat: ',
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
                'required' => true,
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
                            'object_repository' => $this->objectManager->getRepository('User\Entity\Users'),
                            'fields' => 'u_email',
                            'id' => $this->getObject()->getId(),
                            'id_getter' => 'getId',
                            'messages' => array(
                                'User\Form\NoOtherEntityExists'::ERROR_OBJECT_FOUND => "Email address '%value%' already exists",
                            ),
                        ),
                    ),
                ),
            ),

            'u_nickname' => array(
                'required' => false,
            ),

            'u_mobile_phone' => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 11,
                             ),
                    ),
                    array(
                        'name' => 'User\Form\NoOtherEntityExists',
                        'options' => array(
                            'object_repository' => $this->objectManager->getRepository('User\Entity\Users'),
                            'fields' => 'u_mobile_phone',
                            'id' => $this->getObject()->getId(),
                            'id_getter' => 'getId',
                            'messages' => array(
                                'User\Form\NoOtherEntityExists'::ERROR_OBJECT_FOUND => "Phone number '%value%' already exists",
                            ),
                        ),
                    ),
                ),
   
            ),  

            'u_fixed_phone' => array(
                'required' => false,
            ),  

            'u_wechat' => array(
                'required' => false,
            ),  
        );
    }
}
