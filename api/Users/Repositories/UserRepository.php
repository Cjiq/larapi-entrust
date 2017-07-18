<?php

namespace Api\Users\Repositories;

use Api\Users\Models\User;
use Api\Users\Models\Role;
use Infrastructure\Database\Eloquent\Repository;

class UserRepository extends Repository
{
  public function getModel()
  {
    return new User();
  }

  public function getByEmail($email)
  {
    return User::where('email', '=', $email)->first();
  }

  public function create(array $data)
  {
    $user = $this->getModel();

    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

    $user->fill($data);
    $user->save();

    return $user;
  }


  public function update(User $user, array $data)
  {
    $user->fill($data);

    $user->save();

    return $user;
  }

  public function addRole(User $user, Role $role)
  {
      $user->attachRole($role);

      return $user->fresh();
  }

  public function deleteRole(User $user, Role $role)
  {
      $user->detachRole($role);

      return $user->fresh();
  }

}
