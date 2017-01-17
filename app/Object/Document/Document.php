<?php

namespace App\Object\Document;

use App\Object\CC\Entity;
use App\Object\DocumentTemplate\DocumentTemplate;

class Document extends Entity
{
	public $table = 'cc_documents';
   	
    public $timestamps = false;

    public $object_name = "Document";

    public $columns_list = [
    	'Code'=>'code'
    ];

    public function DocumentTemplate()
    {
        return $this->hasOne(DocumentTemplate::class,"id","template");
    }
}


