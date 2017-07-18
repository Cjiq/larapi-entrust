<?php

namespace Api\Users;

use Infrastructure\Events\EventServiceProvider;
use Api\Users\Events\UserWasCreated;
use Api\Users\Events\UserWasDeleted;
use Api\Users\Events\UserWasUpdated;

use Api\Users\Events\RoleWasCreated;
use Api\Users\Events\RoleWasDeleted;
use Api\Users\Events\RoleWasUpdated;
use Api\Users\Events\RoleWasAdded;

use Api\Users\Events\PermissionWasCreated;
use Api\Users\Events\PermissionWasDeleted;
use Api\Users\Events\PermissionWasUpdated;
use Api\Users\Events\PermissionWasAdded;

class UserServiceProvider extends EventServiceProvider
{
    protected $listen = [
        UserWasCreated::class => [
            // listeners for when a user is created
        ],
        UserWasDeleted::class => [
            // listeners for when a user is deleted
        ],
        UserWasUpdated::class => [
            // listeners for when a user is updated
        ],

        RoleWasCreated::class => [
            // listeners for when a role is created
        ],
        RoleWasDeleted::class => [
            // listeners for when a role is deleted
        ],
        RoleWasUpdated::class => [
            // listeners for when a role is updated
        ],
        RoleWasAdded::class => [
            // listeners for when a role is Added
        ],

        PermissionWasCreated::class => [
            // listeners for when a permission is created
        ],
        PermissionWasDeleted::class => [
            // listeners for when a permission is deleted
        ],
        PermissionWasUpdated::class => [
            // listeners for when a permission is updated
        ],
        PermissionWasAdded::class => [
            // listeners for when a permission is added
        ],
    ];
}
