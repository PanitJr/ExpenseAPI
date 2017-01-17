<?php

namespace App\Object\Leave;

use App\Object\CC\Entity;

class Leave extends Entity
{
	public $table = 'cc_leaves';
   	
    public $timestamps = false;

    public $object_name = "Leave";

    public $columns_list = [
    	'leave_name'=>'leavename'
    ];
}


