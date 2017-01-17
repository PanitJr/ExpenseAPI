<?php

namespace App\Object\Expen;

use App\Object\CC\Entity;

class Expen extends Entity
{
	public $table = 'cc_expens';
   	
    public $timestamps = false;

    public $object_name = "Expen";

    public $columns_list = [
    	'Expen Name'=>'expenname'
    ];
}


