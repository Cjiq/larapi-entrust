<?php

namespace Api\Users\Events;

use Infrastructure\Events\Event;
use Api\Users\Models\Permission;
use Api\Users\Models\Role;

class PermissionWasAdded extends Event
{
    public $permission;
    public $role;

    public function __construct(Permission $permission, Role $role)
    {
        $this->permission = $permission;
        $this->role = $role;
    }
}
