<?php

namespace App\Object\Leave;

use App\CC\Loader;
use App\Object\CC\CCDelete as deleteAction;

class CCDelete extends deleteAction
{
	public function checkPermission($request)
    {
    	return false;
    }

}
