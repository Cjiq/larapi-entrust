<?php
namespace Api\Users\Models;

use Infrastructure\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use Api\Users\Models\User;

use Zizaco\Entrust\Traits\EntrustRoleTrait;

class Role extends EntrustRole
{
  use EntrustRoleTrait;

  protected $table = 'role';

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
    'updated_at',
    'pivot'
  ];

}
