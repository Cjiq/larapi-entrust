<?php

namespace Api\Users\Requests;

use Infrastructure\Http\ApiRequest;

class CreatePermissionRequest extends ApiRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'permission' => 'array|required',
      'permission.name' => 'required|string'
    ];
  }

  public function attributes()
  {
    return [
      'permission.name' => 'the permission\'s name'
    ];
  }

}
