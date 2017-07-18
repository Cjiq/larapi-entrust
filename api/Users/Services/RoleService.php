<?php

namespace Api\Users\Services;

use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;
use Api\Users\Exceptions\RoleNotFoundException;
use Api\Users\Exceptions\PermissionNotFoundException;
use Api\Users\Events\RoleWasCreated;
use Api\Users\Events\RoleWasDeleted;
use Api\Users\Events\RoleWasUpdated;
use Api\Users\Events\PermissionWasAdded;
use Api\Users\Events\PermissionWasDeleted;
use Api\Users\Repositories\RoleRepository;
use Api\Users\Repositories\PermissionRepository;

use Api\Users\Models\Role;
use Api\Users\Models\Permission;

class RoleService
{
  private $database;

  private $dispatcher;

  private $roleRepository;

  private $permissionRepository;

  public function __construct(
      DatabaseManager $database,
      Dispatcher $dispatcher,
      RoleRepository $roleRepository,
      PermissionRepository $permissionRepository
  ) {
      $this->database = $database;
      $this->dispatcher = $dispatcher;
      $this->roleRepository = $roleRepository;
      $this->permissionRepository = $permissionRepository;
  }

  public function getAll($options = [])
  {
      return $this->roleRepository->get($options);
  }

  public function getById($roleId, array $options = [])
  {
      $role = $this->getRequestedRole($roleId);

      return $role;
  }

  public function create($data)
  {
      $role = $this->roleRepository->create($data);

      $this->dispatcher->fire(new RoleWasCreated($role));

      return $role;
  }

  public function update($roleId, array $data)
  {
    $role = $this->getRequestedRole($roleId);
    $this->roleRepository->update($role, $data);

    return $role;
  }

  public function delete($roleId)
  {
    $role = $this->getRequestedRole($roleId);
    $this->roleRepository->delete($roleId);

    $this->dispatcher->fire(new RoleWasDeleted($role));
  }

  public function addPermission($roleId, $permissionId)
  {
    $permission = $this->getRequestedPermission($permissionId);
    $role = $this->getRequestedRole($roleId);

    $role = $this->roleRepository->addPermission($role, $permission);

    $this->dispatcher->fire(new PermissionWasAdded($permission, $role));

    return $role->perms;
  }

  public function deletePermission($roleId, $permissionId)
  {
    $role = $this->getRequestedRole($roleId);
    $permission = $this->getRequestedRolePermission($role, $permissionId);

    $role = $this->roleRepository->deletePermission($role, $permission);

    $this->dispatcher->fire(new PermissionWasDeleted($permission, $role));

    return $role->perms;
  }

  private function getRequestedRole($roleId)
  {
    $role = $this->roleRepository->getById($roleId);

    if (is_null($role)) {
        throw new RoleNotFoundException();
    }

    return $role;
  }

  private function getRequestedPermission($permissionId)
  {
    $permission = $this->permissionRepository->getById($permissionId);

    if (is_null($permission)) {
        throw new PermissionNotFoundException();
    }

    return $permission;
  }

  private function getRequestedRolePermission(Role $role, $permissionId)
  {
    if (count($role->perms->find($permissionId)) == 0)
    {
        throw new PermissionNotFoundException("Role does not have permission with id: $permissionId");
    }

    $permission = $this->permissionRepository->getById($permissionId);

    if (is_null($permission)) {
        throw new PermissionNotFoundException("Permission does not exist.");
    }

    return $permission;
  }
}
