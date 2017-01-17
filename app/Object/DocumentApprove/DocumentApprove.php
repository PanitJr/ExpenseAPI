<?php

namespace App\Object\DocumentApprove;

use App\Object\CC\Entity;

class DocumentApprove extends Entity
{
	public $table = 'cc_documentapproves';
   	
    public $timestamps = false;

    public $object_name = "DocumentApprove";

    public $columns_list = [
    	'code'=>'code'
    ];
}


