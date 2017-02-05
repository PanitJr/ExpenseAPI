<?php

namespace App\Object\Item;

use App\CC\Loader;
use App\Object\CC\CCDelete as delete;
use Illuminate\Support\Facades\Auth;

class CCDelete extends delete
{
	public function checkPermission($request)
    {
        $accesstion=false;
        //Auth::loginUsingId(9);
        $record = (int)$request->route('record');
        if(!empty($record)){
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'delete' && $permission->objectid == '8'){
                        $accesstion = true;
                        break;
                    }
                }
            }
        }
        return $accesstion;
    }

    public function process($request)
    {
    	return parent::process($request);
    }
}
