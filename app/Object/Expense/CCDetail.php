<?php

namespace App\Object\Expense;

use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCDetail as detailAction;
use Illuminate\Support\Facades\Auth;

class CCDetail extends detailAction
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
    public function convertData($objectModel)
    {
        $objectModel->entity;
        $objectModel->items;
        $objectModel->retriveStatus;
        $objectModel->retriveApprove;
        return $objectModel;
    }

}
