<?php

namespace Api\Users\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;
use Api\Users\Exceptions\UserNotFoundException;
use Api\Users\Exceptions\RoleWasNotFoundException;
use Api\Users\Exceptions\InvalidRoleException;
use Api\Users\Events\UserWasCreated;
use Api\Users\Events\UserWasDeleted;
use Api\Users\Events\UserWasUpdated;
use Api\Users\Events\RoleWasAdded;
use Api\Users\Events\RoleWasDeleted;
use Api\Users\Repositories\UserRepository;
use Api\Users\Repositories\RoleRepository;

use Api\Users\Models\User;
use Api\Users\Models\Role;

class UserService
{
  private $auth;

  private $database;

  private $dispatcher;

  private $userRepository;

  private $roleRepository;

  public function __construct(
    AuthManager $auth,
    DatabaseManager $database,
    Dispatcher $dispatcher,
    UserRepository $userRepository,
    RoleRepository $roleRepository
  ) {
    $this->auth = $auth;
    $this->database = $database;
    $this->dispatcher = $dispatcher;
    $this->userRepository = $userRepository;
    $this->roleRepository = $roleRepository;
  }

  public function getAll($options = [])
  {
    return $this->userRepository->get($options); 
  }

  public function getById($userId, array $options = [])
  {
    $user = $this->getRequestedUser($userId);
    return $user;
  }

  public function getByEmail($data, array $options = [])
  {
    $user = $this->userRepository->getByEmail($data);
    if (is_null($user)) {
      throw new UserNotFoundException();
    }
    return $user;
  }

  public function create($data)
  {
    $user = $this->userRepository->create($data);

    $this->dispatcher->fire(new UserWasCreated($user));

    return $user;
  }

  public function update($userId, array $data)
  {
    $user = $this->getRequestedUser($userId);

    $this->userRepository->update($user, $data);

    $this->dispatcher->fire(new UserWasUpdated($user));

    return $user;
  }

  public function delete($userId)
  {
    $user = $this->getRequestedUser($userId);

    $this->userRepository->delete($userId);

    $this->dispatcher->fire(new UserWasDeleted($user));
  }

  public function addRole($userId, $roleId)
  {
      $role = $this->getRequestedRole($roleId);
      $user = $this->getRequestedUser($userId);

      $user = $this->userRepository->addRole($user, $role);

      $this->dispatcher->fire(new RoleWasAdded($role, $user));

      return $user->roles;
  }

  public function deleteRole($userId, $roleId)
  {
      $user = $this->getRequestedUser($userId);
      $role = $this->getRequestedUserRole($user, $roleId);

      $user = $this->userRepository->deleteRole($user, $role);

      $this->dispatcher->fire(new RoleWasDeleted($role, $user));

      return $user->roles;
  }

  private function getRequestedUser($userId)
  {
      $user = $this->userRepository->getById($userId);

      if (is_null($user)) {
          throw new UserNotFoundException();
      }

      return $user;
  }

  private function getRequestedRole($roleId)
  {
      $role = $this->roleRepository->getById($roleId);

      if (is_null($role)) {
          throw new RoleNotFoundException();
      }

      return $role;
  }

  private function getRequestedUserRole(User $user, $roleId)
  {
      if (count($user->roles->find($roleId)) == 0)
      {
          throw new RoleNotFoundException("User does not have role with id: $roleId");
      }

      $role = $this->roleRepository->getById($roleId);

      if (is_null($role)) {
          throw new RoleNotFoundException("Role does not exist.");
      }

      return $role;
  }

}
