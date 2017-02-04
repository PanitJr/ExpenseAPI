<?php

namespace App\Object\Expense;

use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCEdit as editAction;
use Illuminate\Support\Facades\Auth;
use Object\Expense\expenseUtil\Approve;

class CCEdit extends editAction
{
    public function checkPermission($request)
    {
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject('Expense');
        $objectModel = $objectClass::find($record);
        $error_code = "ACCESS_DENIED";

        $permission=false;
        //Auth::loginUsingId(9);
        $record = (int)$request->route('record');

        foreach (Auth::user()->profiles as $profile){
            foreach ($profile->getPermission as $permission){
                if(empty($record)){
                    if($permission->name == 'create' && $permission->objectid == '9'){
                        $permission = true;
                        break;
                    }
                }
                else if(!empty($record)){
                    if($permission->name == 'edit' && $permission->objectid == '9'){
                        $permission = true;
                        break;
                    }
                }
            }
        }
        if(!$objectModel && !empty($record))
        {
            throw new ApiException($error_code, 'Record not found ! ');
        }

        if($objectModel && $objectModel->entity->deleted ==1)
        {
            throw new ApiException($error_code, 'The record you are trying to view has been deleted.');
        }
        return $permission;
    }
    public function process($request)
    {
        switch ($request->get('approve_action')){
            case 1 : return $this->rejectExpense($request);
                break;
            case 2 : return $this->ApproveExpense($request);
                break;
            default : throw new ApiException('Error Edit Expense', 'Edit expense action does not match with any cases');
                break;
        }
    }
    public function rejectExpense($request){
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject('Expense');
        $expense = $objectClass::find($record);
        $expense->status = $request->get('approve_action');
        $expense->save();
        $expenseItems = $expense->items;
        foreach ($expenseItems as $expenseItem){
            $expenseItem->status = 3;
            $expenseItem->save();
        }
        $approve = new Approve();
        $approve->approve_action = $request->get('approve_action');
        $approve->user_id = Auth::user()->id;
        $approve->expense_id = $expense->id;
        $approve->save();
        $expense->delete();
        return $expense;
    }

    private function ApproveExpense($request)
    {
        $currentUser = Auth::user();
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject('Expense');
        $expense = $objectClass::find($record);
        $expense->status = $request->get('approve_action');
        if($currentUser->role->name == 'Admin'){
            $expense->admin_approve = true;
        }
        if($currentUser->role->name == 'Supervisor'){
            $expense->supervisor_approve = true;
        }
        $expense->save();
        return $expense;
    }

}