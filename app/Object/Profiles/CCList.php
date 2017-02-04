<?php

namespace App\Object\Profiles;

use App\CC\Loader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Object\CC\CCList as ListAction;
class CCList extends ListAction
{
    public function checkPermission($request)
    {
        $permission=false;
        //Auth::loginUsingId(14);
        foreach (Auth::user()->profiles as $profile){
            foreach ($profile->getPermission as $permission){
                if($permission->name == 'view' && $permission->objectid == '6'){
                    $permission = true;
                    break;
                }
            }
        }
        return $permission;
    }
    public function process($request)
    {

        $result = parent::process($request);
        foreach ($result['listInfo'] as $profile){
            $profile->entity;
        }
        return $result;

    }
}
