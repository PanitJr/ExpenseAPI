<?php

namespace App\Object\Item;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Object\CC\CCList as CList;
class CCList extends CList
{
    public function checkPermission($request)
    {
        $accession=false;
        //Auth::loginUsingId(658);
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'view' && $permission->objectid == '8'){
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
        $result = $this->recordControl($parentResult);
        return $result;
    }
    public function recordControl($result)
    {
        $currentUser = Auth::user();
        $currentUser->role;
        foreach ($result['listInfo'] as $index => $item){
            $item->entity;
//            if($currentUser->role->name == 'Admin'){
//                $item->retriveStatus;
//                $item->retriveOpportunity;
//                $item->retriveCategory;
//                $item->date = date("d-m-Y",strtotime($item->date));
//                continue;
//            }
            if ($currentUser->id == $item['entity']['ownerid'] ){
                $item->retriveStatus;
                $item->retriveOpportunity;
                $item->retriveCategory;
                $item->date = date("d-m-Y",strtotime($item->date));
                continue;
            }
            else if($currentUser->role->name == 'Supervisor' ){
                foreach ($currentUser->child as $child){
                    if ($child->id == $item['entity']['ownerid']) {
                        $item->retriveStatus;
                        $item->retriveOpportunity;
                        $item->retriveCategory;
                        $item->date = date("d-m-Y",strtotime($item->date));
                        continue;
                    }
                    else{
                        unset($result['listInfo'][$index]);
                    }
                }
            }
            else{
                unset($result['listInfo'][$index]);
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
        else{
            $listModel  = $listModel->orderBy('id',"DESC");
        }

        return $listModel;
    }

}
