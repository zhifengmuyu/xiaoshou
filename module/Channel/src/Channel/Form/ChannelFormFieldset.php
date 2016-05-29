<?php
namespace Channel\Form;

use Channel\Entity\Channel;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ChannelFormFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('channel');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Channel());

        $this->add(array(
            'name' => 'c_id',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name'    => 'c_xref_u_id',
            'type' => 'hidden',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name'    => 'c_type',
            'type'    => 'select',
            'options' => array(
                'label' => 'Please choose the Channel type: ',
                'empty_option' => 'Channel type',
                'value_options' => array(
                    '0' => 'mobile phone',
                    '1' => 'computer',
                    '2' => 'car',
                    '4' => 'software',
                ),
            ),
        ));

        $this->add(array(
            'name'    => 'c_name',
            'options' => array(
                'label' => 'Name: '
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name'    => 'c_description',
            'options' => array(
                'label' => 'Description: '
            ),
            'attributes' => array(
                'type' => 'textarea',
                'rows' => '10',
                'cols' => '50',
            ),
        ));

        $this->add(array(
            'name'    => 'c_creation',
            'type' => 'hidden',
            'options' => array(
                'label' => 'Creation: '
            ),
        ));

        $this->add(array(
            'name'    => 'c_deleted',
            'type' => 'hidden',
            'options' => array(
                'label' => 'Deleted: '
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
            'c_id' => array(
                'required' => false,
            ),

            'c_creation' => array(
                'required' => false,
            ),

            'c_deleted' => array(
                'required' => false,
            ),

            'c_xref_u_id' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
            ),
            'c_type' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 1,
                        ),
                    ),
                ),
            ),
            'c_name' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 1,
                        ),
                    ),
                ),
            ),
            'c_description' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 1,
                        ),
                    ),
                ),
            ),
        );
    }
}
