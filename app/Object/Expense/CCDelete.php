<?php

namespace App\Object\Expense;

use App\Object\CC\CCDelete as delete;
class CCDelete extends delete
{
	public function checkPermission($request)
    {
    	return false;
    }

}
