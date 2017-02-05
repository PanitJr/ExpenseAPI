<?php

namespace App\Object\Expense;



use App\Object\Item\Item;
use App\Object\Opportunity\Opportunity;
use App\Object\CC\CCSave as saveAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CCSave extends saveAction
{
    public function checkPermission($request)
    {
        $accession = false;
        foreach (Auth::user()->profiles as $profile){
            foreach ($profile->getPermission as $permission){
                if($permission->name == 'create' && $permission->objectid == '9'){
                    $accession = true;
                }
            }
        }
        return $accession;
    }
    public function process($request)
    {
        $createdExpense = array();
        $currentUser = Auth::user();
        $ativeOpps = Opportunity::where('active',1)->get();
        //var_dump($currentUser);
        foreach ($ativeOpps as $ativeOpp) {
            $itemNotSubmit = DB::table('cc_items')->join('entitys', 'cc_items.id', '=', 'entitys.id')
                ->where('ownerid', '=', $currentUser->id)
                ->where('status', '<>', 2)
                ->where('opportunity', '=', $ativeOpp->id)
                ->select('cc_items.id')
                ->get();
            //var_dump($itemNotSubmit);
            if(!empty($itemNotSubmit)){
                $expense = new Expense();
                $expense->opportunity=$ativeOpp->id;
                $expense->status=1;
                $expense->user_id=$currentUser->id;
                $expense->save();
                $savedExpense = Expense::find($expense->id);
                $totalPrice = 0;
                foreach ($itemNotSubmit as $item){
                    $loadedItem = Item::find($item->id);
                    $loadedItem->status = 2;
                    $loadedItem->expense_id = $savedExpense->id;
                    $loadedItem->save();
                    $totalPrice += $loadedItem->cost;
                }
                $savedExpense->total_price= $totalPrice;
                $savedExpense->expensename = $currentUser->user_name.'-Expense-'.$savedExpense->id;
                $savedExpense->save();
                array_push($createdExpense,$savedExpense);
            }
        }
        return $createdExpense;
    }

}
