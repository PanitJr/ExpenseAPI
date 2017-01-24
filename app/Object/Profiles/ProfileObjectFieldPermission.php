<?php

namespace App\Object\Profiles;

use Illuminate\Database\Eloquent\Model;

class ProfileObjectFieldPermission extends Model
{
	public $table = 'profile_object_permission';
   	
    public $timestamps = false;

    public function permission()
    {
    	return $this->hasOne(Permission::class,'id','permission_id');
    }
}
	

