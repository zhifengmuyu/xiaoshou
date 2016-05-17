<?php

namespace User\Service;

use User\Model\UserInterface;

interface UserServiceInterface
{
    public function findAllUsers();

    public function findUser($id); 
}
