<?php
namespace User\Form;
 
use User\Entity\Users;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
 
class LoginFormFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('login');
 
        $this->add(array(
            'name' => 'login_id',
            'options' => array(
                'label' => 'ID: ',
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
            'login_id' => array(
                'required' => true,
            ),
            'password' => array(
                'required' => true,
            ),
        );
    }
}
