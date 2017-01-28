<?php

namespace App\Object\Item;

use App\CC\Loader;
use App\Object\CC\CCSave as CSave;

class CCSave extends CSave
{
    public function checkPermission($request)
    {
        return true;
    }
    
    public function process($request)
    {
    	return parent::process($request);
    }
}
