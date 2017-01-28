<?php

namespace App\Object\Users;

use App\Object\CC\CCList as cList;
use App\Object\Role\Role;

class CCList extends cList
{
    public function checkPermission($request)
    {
        $permission=false;
        //Auth::loginUsingId(9);
        $record = (int)$request->route('record');
        if(empty($record)){
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'view' && $permission->objectid == '5'){
                        $permission = true;
                        break;
                    }
                }
            }
        }

        return $permission;
    }
    public function process($request)
    {

        $result = parent::process($request);
        foreach ($result['listInfo'] as $user){
            $user->Role = Role::find($user->Role);
        }
        return $result;

    }

}
