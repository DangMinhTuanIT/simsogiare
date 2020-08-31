<?php

namespace Spatie\Permission\Exceptions;

use InvalidArgumentException;

class PermissionDoesNotExist extends InvalidArgumentException
{
    public static function create($permissionName, $guardName = '')
    {
        return new static("There is no permission named `{$permissionName}` for guard `{$guardName}`.");
    }

    public static function withId($permissionId)
    {
        return new static("There is no [permission] with id `{$permissionId}`.");
    }
}
