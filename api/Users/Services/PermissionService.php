<?php

namespace Api\Users\Services;

use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;
use Api\Users\Exceptions\PermissionNotFoundException;
use Api\Users\Events\PermissionWasCreated;
use Api\Users\Events\PermissionWasDeleted;
use Api\Users\Events\PermissionWasUpdated;
use Api\Users\Repositories\PermissionRepository;

class PermissionService
{
  private $database;

  private $dispatcher;

  private $permissionRepository;


  public function __construct(
      DatabaseManager $database,
      Dispatcher $dispatcher,
      PermissionRepository $permissionRepository
  ) {
      $this->database = $database;
      $this->dispatcher = $dispatcher;
      $this->permissionRepository = $permissionRepository;
  }

  public function getAll($options = [])
  {
      return $this->permissionRepository->get($options);
  }

  public function getById($permissionId, array $options = [])
  {
      $permission = $this->getRequestedPermission($permissionId);

      return $permission;
  }

  public function create($data)
  {
      $permission = $this->permissionRepository->create($data);

      $this->dispatcher->fire(new PermissionWasCreated($permission));

      return $permission;
  }

  public function update($permissionId, array $data)
  {
    $permission = $this->getRequestedPermission($permissionId);
    $this->permissionRepository->update($permission, $data);

    return $permission;
  }

  public function delete($permissionId)
  {
    $permission = $this->getRequestedPermission($permissionId);
    $this->permissionRepository->delete($permissionId);

    $this->dispatcher->fire(new PermissionWasDeleted($permission));
  }

  private function getRequestedPermission($permissionId)
  {
    $permission = $this->permissionRepository->getById($permissionId);

    if (is_null($permission)) {
        throw new PermissionNotFoundException();
    }

    return $permission;
  }

}
