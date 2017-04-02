<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/23/2017
 * Time: 9:13 AM
 */

namespace App\Object\Expense;


use App\Object\Expense\expenseUtil\Approve;
use Illuminate\Support\Facades\Auth;
use App\CC\Loader;

class ApproveExpense
{
    public function checkPermission($request)
    {
        $accession=false;
        //Auth::loginUsingId(9);
        if (Auth::user()->id == $request->get('approver')){
            $accession = true;
        }
        return $accession;
    }
    public function process($request)
    {
        $objectClass =  Loader::getObject('Expense');
        $objectModel = $objectClass::find($request->get('id'));
        $currentUser = Auth::user();
        if($currentUser->role->name == 'Supervisor'){
            $objectModel->status = 4;
            $objectModel->approver = $currentUser->supervisor_id;
            $approve = new Approve();
            $approve->expense = $objectModel->id;
            $approve->action = 2;
            $approve->user = $currentUser->id;
            $approve->comment = $request->get('comment');
            $approve->save();
        }
        if($currentUser->role->name == 'Admin'){
            $objectModel->status = 6;
            $approve = new Approve();
            $approve->expense = $objectModel->id;
            $approve->action = 1;
            $approve->user = $currentUser->id;
            $approve->comment = $request->get('comment');
            $approve->save();
        }

        $objectModel->save();
        $objectModel->retriveApprove;
        return $objectModel;
    }
}