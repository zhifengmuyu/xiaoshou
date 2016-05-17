<?php

namespace User\Model;

use Zend\Auth\Adapter\AdapterInterface;

class AuthAdapter implements AdapterInterface
{
    public function __construct($username, $password)
    {
        
    }

    public function authenticate() 
    {
    }
}
