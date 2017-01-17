<?php

namespace App\Http\Controllers\Object;

use File;
use App\CC\Loader;
use Illuminate\Http\Request;
use App\apiResponse;
use App\CC\ObjectBasic;
use App\CC\Error\ApiException;
use Illuminate\Support\Facades\Auth;

class ObjectController extends BaseObjectController
{
    public function object_home()
    {
        //$Document = ObjectBasic=>=>whereIn('id',[3,4])->orderBy('objsequence')->get();
        if(Auth::User()->role_id == 1) {
            $Document = [
                ["id" => 2, "name" => "Item", "tablename" => "cc_item", "fieldname" => "itemname", "label" => "Item", "icon" => "art_track", "objsequence" => 2],
                ["id" => 3, "name" => "Leave", "tablename" => "cc_leave", "fieldname" => "leavename", "label" => "Leave", "icon" => "art_track", "objsequence" => 3],
                ["id" => 4, "name" => "Expense", "tablename" => "cc_expense", "fieldname" => "expensename", "label" => "All Expense", "icon" => "art_track", "objsequence" => 4],
                ["id" => 5, "name" => "AllLeave", "tablename" => "cc_leave", "fieldname" => "leavename", "label" => "All Leave", "icon" => "verified_user", "objsequence" => 5]
            ];
            // $Document = ObjectBasic=>=>whereIn('id',[1,2,3,4])->orderBy('objsequence')->get();
            //$Manage = ObjectBasic::whereIn('id',[5,6])->orderBy('objsequence')->get();
            $Manage = [
                ["id" => 5, "name" => "Users", "tablename" => "users", "fieldname" => "email", "label" => "Users", "icon" => "people", "objsequence" => 6]
            ];
        }else{
            $Document = [
                ["id" => 2, "name" => "Item", "tablename" => "cc_item", "fieldname" => "itemname", "label" => "Item", "icon" => "art_track", "objsequence" => 2],
                ["id" => 3, "name" => "Leave", "tablename" => "cc_leave", "fieldname" => "leavename", "label" => "Leave", "icon" => "art_track", "objsequence" => 3],
                ["id" => 4, "name" => "Expense", "tablename" => "cc_expense", "fieldname" => "expensename", "label" => "All Expense", "icon" => "art_track", "objsequence" => 4],
                ["id" => 5, "name" => "AllLeave", "tablename" => "cc_leave", "fieldname" => "leavename", "label" => "All Leave", "icon" => "verified_user", "objsequence" => 5]
            ];
            $Manage = [];
        }
        return apiResponse::success([
                'list'=>$Document,
                'manage'=>$Manage
            ]); 
    }

    public static function getResult(Request $Request,$objectName,$processFile)
    {
        $className = Loader::getObjectClassName($processFile,$objectName);
        $handler = new $className();
        return self::run($handler,$Request);
    }

}
