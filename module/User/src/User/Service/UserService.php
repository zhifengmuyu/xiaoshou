<?php

namespace User\Service;

use User\Mapper\UserMapperInterface;

class UserService implements UserServiceInterface
{

    protected $userMapper;

    public function __construct(UserMapperInterface $userMapper) 
    {
        $this->userMapper = $userMapper;
    }

    public function findAllUsers()
    {
        return $this->userMapper->findAll();
    }

    public function findUser($email)
    {
        return $this->userMapper->find($email);
    }
}
