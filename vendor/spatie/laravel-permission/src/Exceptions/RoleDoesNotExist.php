<?php

namespace Spatie\Permission\Exceptions;

use InvalidArgumentException;

class RoleDoesNotExist extends InvalidArgumentException
{
    public static function named($roleName)
    {
        return new static("There is no role named `{$roleName}`.");
    }

    public static function withId($roleId)
    {
        return new static("There is no role with id `{$roleId}`.");
    }
}
