<?php

namespace User\Mapper;

use User\Model\UserInterface;

interface UserMapperinterface
{
    public function find($email);

    public function findAll();
}
