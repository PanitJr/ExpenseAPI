<?php

namespace App\Object\Expense;

use App\CC\Loader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Object\CC\CCList as listAction;
class CCList extends listAction
{
    public function checkPermission($request)
    {
        $accession=false;
        //Auth::loginUsingId(14);
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'view' && $permission->objectid == '9'){
                        $accession = true;
                        break;
                    }
                }
            }
        return $accession;
    }
    public function process($request)
    {
        $parentResult = parent::process($request);
        $parentResult['listInfo'] = $this->recordControl($parentResult['listInfo']);
        return $parentResult;
    }
    public function recordControl($result)
    {
        $currentUser = Auth::user();
        $currentUser->role;
        foreach ($result as $index => $expense){
            $expense->entity;
            if($currentUser->role->name == 'Admin'){
                $expense->retriveStatus;
                $expense->retriveOpportunity;
                continue;
            }
            else if ($currentUser->id == $expense['entity']['ownerid'] ){
                $expense->retriveStatus;
                $expense->retriveOpportunity;
                continue;
            }
            else if($currentUser->role->name == 'Supervisor' ){
                foreach ($currentUser->child as $child){
                    if ($child->id == $expense['entity']['ownerid']) {
                        $expense->retriveStatus;
                        $expense->retriveOpportunity;
                        continue;
                    }
                    else{
                        unset($result[$index]);
                    }
                }
            }
            else{
                unset($result[$index]);
            }
        }
        return $result;
    }
    public function getList($request,$objectClass)
    {
        $order = $request->get('order');
        $listModel = $objectClass::join('entitys',function($join) use($objectClass){
            $table = $objectClass::instance()->table;
            $join->on($table.'.id', '=', 'entitys.id');
            $join->where('entitys.deleted', '=', 0);
            //$join->where($table.'.status', '<>', 2);
        });


        if($order)
        {
            $by = Str::substr($order,0,1)==="-"?"DESC":"ASC";
            $order = $by==="DESC"?Str::substr($order,1):$order;
            $listModel  = $listModel->orderBy($order,$by);
        }

        return $listModel;
    }

}
