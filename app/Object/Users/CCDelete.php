<?php

namespace App\Object\Users;

use App\CC\Loader;
use Illuminate\Support\Facades\Auth;
use App\Object\CC\CCDelete as delete;

class CCDelete extends delete
{
	public function checkPermission($request)
    {
        $permission=false;
        //Auth::loginUsingId(9);
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'delete' && $permission->objectid == '5'){
                        $permission = true;
                        break;
                    }
                }
            }
    	return $permission;
    }
}
