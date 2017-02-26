<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/25/2017
 * Time: 7:54 PM
 */

namespace App\Object\Item;


use App\CC\Loader;
use Illuminate\Support\Facades\Auth;

class RejectItem
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
            $objectClassItem =  Loader::getObject('Item');
            $objectItem = $objectClassItem::find((int)$request->route('record'));
            $objectItem->expense_id = null;
            $objectItem->status = 3;
            $objectItem->save();
        return $objectItem;
    }
}