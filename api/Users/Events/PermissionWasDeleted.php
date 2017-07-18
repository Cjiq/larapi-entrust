<?php

namespace Api\Users\Events;

use Infrastructure\Events\Event;
use Api\Users\Models\Permission;
use Api\Users\Models\Role;

class PermissionWasDeleted extends Event
{
    public $permission;
    public $role;

    public function __construct(Permission $permission, Role $role = null)
    {
        $this->permission = $permission;
        $this->role = $role;
    }
}
