<?php

namespace App\Object\Profile;

use App\Object\CC\Entity;

class Profile extends Entity
{
	public $table = 'profiles';
   	
    public $timestamps = false;

    public $object_name = "Profile";

    public $columns_list = [
    	'Profile Name'=>'profilename',
    	'Description'=>'Description',
    ];

    public function objects()
    {
    	return $this->belongsToMany(ObjectModel::class, 'profile_object', 'profile_id', 'object_id');
    }

    public function getPermissionObject($objectModel)
    {
        
    }
}
	

