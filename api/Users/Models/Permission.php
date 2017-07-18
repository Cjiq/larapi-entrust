<?php
namespace Api\Users\Models;

use Infrastructure\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

use Zizaco\Entrust\Traits\EntrustPermissionTrait;

class Permission extends EntrustPermission
{
  use EntrustPermissionTrait;

  protected $table = 'permission';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'display_name',
    'description'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

}
