<?php

namespace App\Object\Users;

use Auth;

class Current 
{
	public function checkPermission($request)
    {
    	return true;
    }
    
    public function process($request)
    {
    	return [
            "user"=>Auth::user()
        ];
    }
}
