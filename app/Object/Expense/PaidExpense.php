<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/26/2017
 * Time: 2:22 PM
 */

namespace App\Object\Expense;


use App\CC\Loader;
use App\Object\Expense\expenseUtil\Approve;
use Illuminate\Support\Facades\Auth;

class PaidExpense
{
    public function checkPermission($request)
    {
        $accession=false;
        //Auth::loginUsingId(14);
        if (Auth::user()->role->name == 'Admin'){
            $accession = true;
        }
        return $accession;
    }
    public function process($request)
    {
            $objectClass =  Loader::getObject('Expense');
            $objectModel = $objectClass::find($request->route('record'));
            if($objectModel->status == 6){
                $objectModel->status = 3;
                $objectModel->items;
                foreach ($objectModel->items as $item){
                    $objectClassItem =  Loader::getObject('Item');
                    $objectItem = $objectClassItem::find($item->id);
                    $objectItem->status = 4;
                    $objectItem->save();
                }
                $approve = new Approve();
                $approve->expense = $objectModel->id;
                $approve->action = 4;
                $approve->user = Auth::user()->id;
                $approve->save();
                $objectModel->save();
            }
        return $objectModel;
    }

}