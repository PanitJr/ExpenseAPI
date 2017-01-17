<?php

namespace App\Object\ObjectName;

use App\Object\CC\Entity;

class ObjectName extends Entity
{
	public $table = '<<tablename>>';
   	
    public $timestamps = false;

    public $object_name = "ObjectName";

    public $columns_list = [
    	'<<field_label>>'=>'<<field_name>>'
    ];
}


