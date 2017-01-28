<?php

namespace App\Object\Users;

use App\Object\CC\CCList as cList;
use App\Object\Role\Role;
use Illuminate\Support\Facades\Auth;

class CCList extends cList
{
    public function checkPermission($request)
    {
        $permission=false;
        //Auth::loginUsingId(14);
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
        $parentResult = parent::process($request);
        $result = $this->recordControl($parentResult);
        return $result;
    }
    public function recordControl($result)
    {
        $currentUser = Auth::user();
        $currentUser->role;
        foreach ($result['listInfo'] as $index => $user){
            if($currentUser->role->name == 'Admin'){
                $user->role;
                continue;
            }
            else if ($currentUser->id == $user->id ){
                $user->role;
                continue;
            }
            else if($currentUser->role->name == 'Supervisor' ){
                foreach ($currentUser->child as $child){
                    if ($child->id == $user->id) {
                        $user->role;
                        continue;
                    }
                    else{
                        unset($result['listInfo'][$index]);
                    }
                }
            }
            else{
                unset($result['listInfo'][$index]);
            }
        }
        return $result;
    }

}
