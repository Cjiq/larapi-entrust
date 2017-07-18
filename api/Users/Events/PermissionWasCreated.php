<?php

namespace Api\Users\Events;

use Infrastructure\Events\Event;
use Api\Users\Models\Permission;

class PermissionWasCreated extends Event
{
    public $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
}
