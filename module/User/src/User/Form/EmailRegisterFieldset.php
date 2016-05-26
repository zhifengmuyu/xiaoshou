<?php
namespace User\Form;
 
use User\Entity\Users;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
 
class RegisterFormFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('register');
 
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
            'name' => 'u_password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password: ',
            ),
            'attributes' => array(
                'type' => 'password',
            )
        ));

        $this->add(array(
            'type'       => 'password',
            'name'       => 'passwordVerify',
            'options'    => array(
                'label' => 'Verify password: ',
            ),
        ));

        $this->add(array(
            'type'       => 'select',
            'name'       => 'u_type',
            'options'  => array(
                'label' => 'Account type: ',
                'empty_option' => 'Choose account type',
                'value_options' => array(
                    'seller' => 'Seller',
                    'buyer' => 'Buyer',
                ),
            ),
        ));        

        $this->add(array(
            'type'       => 'select',
            'name'       => 'u_channels',
            'options'  => array(
                'label' => 'Select your channels: ',
                'empty_option' => 'Select Channels',
                'value_options' => array(
                    'software' => 'Software',
                    'datacenter' => 'Datacenter',
                ),
            ),
        ));  

        $this->add(array(
            'type'       => 'select',
            'name'       => 'u_products',
            'options'  => array(
                'label' => 'Select your products: ',
                'empty_option' => 'Select Products',
                'value_options' => array(
                    'apple' => 'Apple',
                    'orange' => 'Orange',
                ),
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

            'u_type' => array(
                'required' => true,
            ),

            'u_channels' => array(
                'required' => false,
            ),

            'u_products' => array(
                'required' => false,
            ),

            'u_nickname' => array(
                'required' => false,
            ),

            'u_mobile_phone' => array(
                'required' => false,
            ),  

            'u_fixed_phone' => array(
                'required' => false,
            ),  

            'u_wechat' => array(
                'required' => false,
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
