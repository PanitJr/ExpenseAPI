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
        if ($currentUser->id == $record){
            $accession = true;
        }
        else if($currentUser->role->name == 'Admin' ){
            $accession = true;
        }
        else if($currentUser->role->name == 'Supervisor' ){
            foreach ($currentUser->child as $child){
                if ($child->id == $record) {
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
            $objectModel->approveAvilable = 0;
        }else{
            $objectModel->approveAvilable = 1;
        }
        return $objectModel;
    }

}
