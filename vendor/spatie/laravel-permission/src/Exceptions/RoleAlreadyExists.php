<?php

namespace Spatie\Permission\Exceptions;

use InvalidArgumentException;

class RoleAlreadyExists extends InvalidArgumentException
{
    public static function create($roleName, $guardName)
    {
        return new static("A role `{$roleName}` already exists for guard `{$guardName}`.");
    }
}
