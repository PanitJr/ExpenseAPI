<?php

namespace App\Object\Profiles;

use App\Object\CC\Entity;
use App\Object\Profiles\ProfileObjectPermission;

class Profiles extends Entity
{
	public $table = 'profiles';
   	
    public $timestamps = false;

    public $object_name = "Profiles";

    public $columns_list = [
    	'Profiles Name'=>'profilename',
    	'Description'=>'Description',
    ];

    public function getPermission()
    {
        return $this->belongsToMany(Permission::class,'profile_object_permission','profile_id','permission_id');
    }
}
	

