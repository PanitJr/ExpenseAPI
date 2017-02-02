<?php

namespace App\Object\Item;

use App\CC\Loader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Object\CC\CCList as CList;
class CCList extends CList
{
    public function checkPermission($request)
    {
        $permission=false;
        //Auth::loginUsingId(14);
        if(empty($record)){
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'view' && $permission->objectid == '8'){
                        $permission = true;
                        break;
                    }
                }
            }
        }
        return $permission;
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
            if($currentUser->role->name == 'Admin'){
                continue;
            }
            else if ($currentUser->id == $item['entity']['ownerid'] ){
                continue;
            }
            else if($currentUser->role->name == 'Supervisor' ){
                foreach ($currentUser->child as $child){
                    if ($child->id == $item['entity']['ownerid']) {
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
            $join->where($table.'.status', '<>', 2);
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
