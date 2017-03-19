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
        $accession=false;
        //Auth::loginUsingId(9);
        $currentUser = Auth::user();
        $currentUser->role;
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject('Expense');
        $objectModel = $objectClass::find($record);

        if ($currentUser->id == $objectModel->user_id){
            $accession = true;
        }
        else if($currentUser->role->name == 'Admin' ){
            $accession = true;
        }
        else if($currentUser->role->name == 'Supervisor' ){
            foreach ($currentUser->child as $child){
                if ($child->id == $objectModel->user_id) {
                    $accession = true;
                    break;
                }
            }
        }
        return $accession;
    }

    public function convertData($objectModel)
    {
        $objectModel->entity;
        $objectModel->items;
        foreach ($objectModel->items as $item){
            $item->retriveCategory;
        }
        $objectModel->retriveStatus;
        $objectModel->retriveOpportunity;
        $objectModel->retriveApprove;
        foreach ($objectModel->retriveApprove as $approve){
            $approve->status;
            $approve->retrieveUser;
        }
        $objectModel->User;
        $objectModel->retriveApprover;
        if($objectModel->approver == Auth::user()->id){
            $objectModel->approveAvilable = false;
        }else{
            $objectModel->approveAvilable = true;
        }
        return $objectModel;
    }

}
