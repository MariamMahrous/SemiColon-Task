<?php

namespace App\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table='groups';
    protected $fillable=['name','description'];


   public function users()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }

  
public function permissions()
{
    return $this->belongsToMany(Permission::class, 'group_permission', 'group_id', 'permission_id');
}

   


}
