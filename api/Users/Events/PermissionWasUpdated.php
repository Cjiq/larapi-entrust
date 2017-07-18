<?php

namespace Api\Users\Events;

use Infrastructure\Events\Event;
use Api\Users\Models\Permission;

class PermissionWasUpdated extends Event
{
    public $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
}
