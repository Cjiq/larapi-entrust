<?php
namespace Api\Users\Repositories;

use Api\Users\Models\Permission;
use Infrastructure\Database\Eloquent\Repository;

class PermissionRepository extends Repository
{
  public function getModel()
  {
    return new Permission();
  }

  public function create(array $data)
  {
    $permission = $this->getModel();

    $permission->fill($data);
    $permission->save();

    return $permission;
  }

  public function update(Permission $permission, array $data)
  {
    $permission->fill($data);

    $permission->save();

    return $permission;
  }
}
