<?php

namespace App\Object\CC;

use App\CC\Loader;

class CCDelete 
{
	public function checkPermission($request)
    {
    	return true;
    }
    
    public function process($request)
    {
    	$objectName = $request->route('objectName');
    	$record = $request->route('record');
		$objectClass = 	Loader::getObject($objectName);
    	$objectModel = $objectClass::find($record);
    	return $objectModel->delete();
    }
}
