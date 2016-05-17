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
        'name' => 'id',
        'attributes' => array(
          'type' => 'hidden',
        ),
        'options' => array(
          'label' => ' ',
        ),
      ));
 
      $this->add(array(
        'name' => 'email',
        'options' => array(
          'label' => 'Email: ',
        ),
        'attributes' => array(
          'type' => 'text'
        ),
      ));
 
      $this->add(array(
        'name' => 'password',
        'options' => array(
          'label' => 'Password: ',
        ),
        'attributes' => array(
          'type' => 'password'
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
            'email' => array(
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
            'password' => array(
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
                            'token' => 'password',
                        ),
                    ),
                ),
            ),
        );
    }
}
