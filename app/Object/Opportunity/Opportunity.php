<?php

namespace App\Object\Opportunity;

use App\Object\CC\Entity;

class Opportunity extends Entity
{
	public $table = 'cc_opportunitys';
   	
    public $timestamps = false;

    public $object_name = "Opportunity";

    public $columns_list = [
    	'name'=>'name'
    ];
}


