<?php
namespace Api\Users\Repositories;

use Api\Users\Models\Role;
use Api\Users\Models\Permission;
use Infrastructure\Database\Eloquent\Repository;

class RoleRepository extends Repository
{
  public function getModel()
  {
    return new Role();
  }

  public function create(array $data)
  {
    $role = $this->getModel();

    $role->fill($data);
    $role->save();

    return $role;
  }

  public function update(Role $role, array $data)
  {
    $role->fill($data);

    $role->save();

    return $role;
  }

  public function addPermission(Role $role, $permission)
  {
    $role->attachPermission($permission);

    return $role->fresh();
  }

  public function deletePermission(Role $role, Permission $permission)
  {
    $role->detachPermission($permission);

    return $role->fresh();
  }

}
