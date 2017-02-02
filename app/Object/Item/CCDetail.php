<?php

namespace App\Object\Item;

use App\Object\CC\CCDetail as Detail;
use Illuminate\Support\Facades\Auth;

class CCDetail extends Detail
{
    public function checkPermission($request)
    {
        $permission=false;
        //Auth::loginUsingId(9);
        $currentUser = Auth::user();
        $currentUser->role;
        $record = (int)$request->route('record');
        if ($currentUser->id == $record){
            $permission = true;
        }
        else if($currentUser->role->name == 'Admin' ){
            $permission = true;
        }
        else if($currentUser->role->name == 'Supervisor' ){
            foreach ($currentUser->child as $child){
                if ($child->id == $record) {
                    $permission = true;
                    break;
                }
            }
        }
        return $permission;
    }

    public function process($request)
    {   
        return parent::process($request);
    }

}
