<?php

namespace Product\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class ProductForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('product');

        $this->setHydrator(new DoctrineHydrator($objectManager));
        $ProductFormFieldset = new ProductFormFieldset($objectManager);
        $ProductFormFieldset->setUseAsBaseFieldset(true);
        $ProductFormFieldset->setOptions(array(
            'label' => ' ',
        ));
        $this->add($ProductFormFieldset);
    }
}

