<?php

namespace App\Object\DocumentGenerate;

use App\Object\CC\Entity;

class DocumentGenerate extends Entity
{
	public $table = 'cc_documentgenerate';
   	
    public $timestamps = false;

    public $object_name = "DocumentGenerate";

    public $columns_list = [
    	'Name'=>'name'
    ];
}


