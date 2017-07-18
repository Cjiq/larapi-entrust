<?php

namespace Api\Users\Events;

use Infrastructure\Events\Event;
use Api\Users\Models\Role;
use Api\Users\Models\User;

class RoleWasAdded extends Event
{
    public $role;
    public $user;

    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }
}
