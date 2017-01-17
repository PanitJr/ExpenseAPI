<?php

namespace App\Object\DocumentTemplate;

use App\Object\CC\Entity;

class DocumentTemplate extends Entity
{
	public $table = 'cc_documenttemplates';
   	
    public $timestamps = false;

    public $object_name = "DocumentTemplate";

    public $columns_list = [
    	'Name'=>'name'
    ];
}


