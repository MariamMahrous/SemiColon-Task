<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{ 
    protected $table='permissions';
    protected $fillable=['name'];

    public function groups()
{
    return $this->belongsToMany(Group::class, 'group_permission', 'permission_id', 'group_id');
}

}
