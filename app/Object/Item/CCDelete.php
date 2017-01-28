<?php

namespace App\Object\Item;

use App\CC\Loader;
use App\Object\CC\CCDelete as delete;

class CCDelete extends delete
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
