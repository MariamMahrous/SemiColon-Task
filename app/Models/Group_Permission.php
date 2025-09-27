<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group_Permission extends Model
{
  protected $table='group_permission';
    protected $fillable=['group_id','permission_id'];
}
