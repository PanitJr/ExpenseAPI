<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/23/2017
 * Time: 9:14 AM
 */

namespace App\Object\Expense;


use App\CC\Loader;
use App\Object\Expense\expenseUtil\Approve;
use Illuminate\Support\Facades\Auth;

class RejectExpense
{
    public function checkPermission($request)
    {
        $accession=false;
        //Auth::loginUsingId(14);
        if (Auth::user()->role->name == 'Admin' || Auth::user()->id == $request->get('user_id')){
            $accession = true;
        }
        return $accession;
    }
    public function process($request)
    {
        $objectClass =  Loader::getObject('Expense');
        $objectModel = $objectClass::find($request->get('id'));
        $currentUser = Auth::user();
        $objectModel->items;
        foreach ($objectModel->items as $item){
            $objectClassItem =  Loader::getObject('Item');
            $objectItem = $objectClassItem::find($item->id);
            $objectItem->expense_id = null;
            $objectItem->status = 3;
            $objectItem->save();
        }
            $objectModel->status = 5;
            $approve = new Approve();
            $approve->expense = $objectModel->id;
            $approve->action = 3;
            $approve->user = $currentUser->id;
            $approve->comment = $request->get('comment');
            $approve->save();
        $objectModel->save();

        $objectModel->delete();
        $objectModel->retriveApprove;
        return $objectModel;
    }
}