<?php
namespace Sp\Form;

use Sp\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ProductFormFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('product');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Product());

        $this->add(array(
            'name' => 'p_id',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name'    => 'p_xref_u_id',
            'type' => 'hidden',
            'options' => array(
                'label' => ' ',
                'class' => 'hidden',
            ),
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name'    => 'p_type',
            'type'    => 'select',
            'options' => array(
                'label' => 'Please choose the product type: ',
                'empty_option' => 'Product type',
                'value_options' => array(
                    '0' => 'mobile phone',
                    '1' => 'computer',
                    '2' => 'car',
                    '4' => 'software',
                ),
            ),
        ));

        $this->add(array(
            'name'    => 'p_name',
            'options' => array(
                'label' => 'Name: '
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name'    => 'p_description',
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
            'name'    => 'p_creation',
            'type' => 'hidden',
            'options' => array(
                'label' => 'Creation: '
            ),
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name'    => 'p_deleted',
            'type' => 'hidden',
            'options' => array(
                'label' => 'Deleted: '
            ),
            'attributes' => array(
                'type' => 'hidden',
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
            'p_id' => array(
                'required' => false,
            ),

            'p_creation' => array(
                'required' => false,
            ),

            'p_deleted' => array(
                'required' => false,
            ),

            'p_xref_u_id' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
            ),
            'p_type' => array(
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
            'p_name' => array(
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
            'p_description' => array(
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
