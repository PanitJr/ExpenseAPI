<?php

namespace App\Object\Users;

use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCDetail as Detail;

class CCDetail extends Detail
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
        else if (Auth::user()->id == $record && !empty($record) ){
            $permission = true;
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
