<?php

namespace App\Object\Expen\taxi;

use Auth;

class price
{	
	public function checkPermission($request)
    {
        return true;
    }
    
    public function process($request)
    {
    	$user = Auth::user();
    	$user->firstname = "Thirawat";
    	$user->save();
    	return Auth::user();
    }
}