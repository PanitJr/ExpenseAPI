<?php

namespace App\Object\Profiles;

use Illuminate\Database\Eloquent\Model;

class ProfileObjectPermission extends Model
{
	public $table = 'profile_object_permission';
   	
    public $timestamps = false;

    public function permission()
    {
    	return $this->hasOne(Permission::class,'id','permission_id');
    }
}
	

