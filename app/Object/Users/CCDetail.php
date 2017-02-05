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
        $accesstion=false;
        //Auth::loginUsingId(9);
        $currentUser = Auth::user();
        $currentUser->role;
        $record = (int)$request->route('record');
        if ($currentUser->id == $record){
            $accesstion = true;
        }
        else if($currentUser->role->name == 'Admin' ){
            $accesstion = true;
        }
        else if($currentUser->role->name == 'Supervisor' ){
            foreach ($currentUser->child as $child){
                if ($child->id == $record) {
                    $accesstion = true;
                    break;
                }
            }
        }
        return $accesstion;
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
    public function convertData($objectModel)
    {
        $objectModel->role;
        $objectModel->getStatus;
        $objectModel->profiles;
        $objectModel->supervisor;
        return $objectModel;
    }

}
