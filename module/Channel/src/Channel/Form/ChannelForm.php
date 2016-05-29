<?php

namespace Channel\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class ChannelForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('channel');

        $this->setHydrator(new DoctrineHydrator($objectManager));
        $channelFormFieldset = new ChannelFormFieldset($objectManager);
        $channelFormFieldset->setUseAsBaseFieldset(true);
        $channelFormFieldset->setOptions(array(
            'label' => ' ',
        ));
        $this->add($channelFormFieldset);
    }
}

