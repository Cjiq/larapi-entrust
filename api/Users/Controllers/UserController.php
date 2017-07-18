<?php

namespace Api\Users\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Api\Users\Requests\CreateUserRequest;
use Api\Users\Requests\UserRolesRequest;
use Api\Users\Requests\UserByEmailRequest;
use Api\Users\Services\UserService;

class UserController extends Controller
{
  private $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function getAll()
  {
    $resourceOptions = $this->parseResourceOptions();

    $data = $this->userService->getAll($resourceOptions);
    $parsedData = $this->parseData($data, $resourceOptions, 'users');
    return $this->response($parsedData);
  }

  public function getById($userId)
  {
    $resourceOptions = $this->parseResourceOptions();
    $data = $this->userService->getById($userId, $resourceOptions);
    $parsedData = $this->parseData($data, $resourceOptions, 'user');

    return $this->response($parsedData);
  }

  public function getByEmail($userEmail)
  {
    $resourceOptions = $this->parseResourceOptions();
    $data = $this->userService->getByEmail($userEmail, $resourceOptions);
    $parsedData = $this->parseData($data, $resourceOptions, 'user');

    return $this->response($parsedData);

  }

  public function create(CreateUserRequest $request)
  {
    $data = $request->get('user', []);

    return $this->response($this->userService->create($data), 201);
  }

  public function update($userId, Request $request)
  {
    $data = $request->get('user', []);

    return $this->response($this->userService->update($userId, $data));
  }

  public function delete($userId)
  {
    return $this->response($this->userService->delete($userId));
  }

  public function addRoles($userId, UserRolesRequest $request)
  {
    $resourceOptions = $this->parseResourceOptions();
    $roles = $request->get('roles', []);

    $data = $this->userService->addRoles($userId, $roles);
    $parsedData = $this->parseData($data, $resourceOptions, 'user');
    
    return $this->response($parsedData);
  }
  public function addRole($userId, $roleId) 
  {
    $resourceOptions = $this->parseResourceOptions();

    $data = $this->userService->addRole($userId, $roleId);
    $parsedData = $this->parseData($data, $resourceOptions, 'roles');

    return $this->response($parsedData, 201);
  }

  public function deleteRole($userId, $roleId) 
  {
    $resourceOptions = $this->parseResourceOptions();

    $data = $this->userService->deleteRole($userId, $roleId);
    $parsedData = $this->parseData($data, $resourceOptions, 'roles');

    return $this->response($parsedData);
  }


}
