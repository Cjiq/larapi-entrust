<?php

namespace Api\Users\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Api\Users\Requests\CreatePermissionRequest;
use Api\Users\Services\PermissionService;

class PermissionController extends Controller
{
  private $permissionService;

  public function __construct(PermissionService $permissionService)
  {
      $this->permissionService = $permissionService;
  }

  public function getAll()
  {
      $resourceOptions = $this->parseResourceOptions();

      $data = $this->permissionService->getAll($resourceOptions);
      $parsedData = $this->parseData($data, $resourceOptions, 'permissions');

      return $this->response($parsedData);
  }

  public function getById($permissionId)
  {
      $resourceOptions = $this->parseResourceOptions();

      $data = $this->permissionService->getById($permissionId, $resourceOptions);
      $parsedData = $this->parseData($data, $resourceOptions, 'permission');

      return $this->response($parsedData);
  }

  public function create(CreatePermissionRequest $request)
  {
      $data = $request->get('permission', []);

      return $this->response($this->permissionService->create($data), 201);
  }

  public function update($permissionId, Request $request)
  {
      $data = $request->get('permission', []);

      return $this->response($this->permissionService->update($permissionId, $data));
  }

  public function delete($permissionId)
  {
      return $this->response($this->permissionService->delete($permissionId));
  }

}
