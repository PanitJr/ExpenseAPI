<?php

namespace App\Object\Role;

use App\Object\CC\Entity;

class Role extends Entity
{
	public $table = 'roles';
   	
    public $timestamps = false;

    public $object_name = "Role";

    public $columns_list = [
    	'name'=>'name'
    ];

    public function parentRole()
    {
    	return $this->hasOne(Role::class,'id','parent_role');
    }

    public function childRole()
    {
    	return $this->hasOne(Role::class,'parent_role','id');
    }  


}


