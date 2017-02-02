<?php

namespace App\Object\Users;

use App\CC\Loader;
use App\CC\Error\ApiException;
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
    public function convertLayout($objectModel)
    {
        $layout = [];
        $Object = $objectModel->getObject();
        $Blocks = $Object->getBlock()->orderby('sequence')->get();
        foreach ($Blocks as $Block) {
            $Fields = $Block->getField()->whereNotIn('fieldname',[
                'password',
                'confirm_password',
                ])->orderby('sequence')->get();
            $Block->fields = $Fields;
        }
        return $Blocks;
    }

}
