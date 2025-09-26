<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable=['name'];

     public function groups()
    {
        return $this->belongsToMany(Group::class, 'Group_Permission', 'permission_id', 'group_id');
    }

}
