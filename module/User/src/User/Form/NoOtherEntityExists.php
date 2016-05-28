<?php

namespace User\Form;

use Zend\Validator\Exception\InvalidArgumentException;
use DoctrineModule\Validator\NoObjectExists;

class NoOtherEntityExists extends NoObjectExists
{
    private $id; //id of the entity to edit
    private $id_getter;  //getter of the id
    private $additionalFields = null; //other fields

    public function __construct(array $options)
    {
        parent::__construct($options);
         if (isset($options['additionalFields'])) {
          $this->additionalFields = $options['additionalFields'];
         }
        $this->id = $options['id'];
        $this->id_getter = $options['id_getter'];
    }

    public function isValid($value, $context = null)
    {
        if (null != $this->additionalFields && is_array($context)) {
            $value = (array) $value;
            foreach ($this->additionalFields as $field) {
                $value[] = $context[$field];
            }
        }
        $value = $this->cleanSearchValue($value);
        $match = $this->objectRepository->findOneBy($value);

        if (is_object($match) && $match->{$this->id_getter}() != $this->id) {
            if (is_array($value)) {
                $str = '';
                foreach ($value as $campo) {
                    if ($str != '') {
                        $str .= ', ';
                    }
                    $str .= $campo;
                }
                $value = $str;
            }
            $this->error(self::ERROR_OBJECT_FOUND, $value);
            return false;
        }
        return true;
    }
}