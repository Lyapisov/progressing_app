<?php


namespace App\UserAccess\Test\Helper;


trait UserAccessTrait
{
    public function getUserBuilder(): UserBuilder
    {
        return new UserBuilder();
    }
}
