<?php

namespace App\Object\Document;

use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCEdit as Edit;

class CCEdit extends Edit
{   
    public function convertData($objectModel)
    {
    	$objectModel->DocumentTemplate;
        return $objectModel;
    }
}