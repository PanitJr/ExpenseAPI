<?php

namespace App\Object\CC;

use App\CC\Loader;
use Illuminate\Support\Str;
class CCList 
{
    public function checkPermission($request)
    {
        return false;
    }
    
    public function process($request)
    {
    	$objectName =$request->route('objectName');
        $objectClass =  Loader::getObject($objectName);

        $page = $request->get('limit',25);

        $listModel = $this->getList($request,$objectClass);
        
        $columns = $this->getCollumns($request,$objectClass::instance());
        
        $listModel = $this->filter($request,$listModel,$columns);

        $select = array_merge(["entitys.id"],$columns);
        
        $list = $listModel->paginate($page,$select);
        $result=[
            'header' => $columns,
            'listInfo' => $list,
        ]; 
        return $result; 

    }

    public function filter($request,$listModel,$columns)
    {
        $search = $request->get('search',null);
        
        if(!empty($search))
        {
            $listModel = $this->search($listModel,$search,$columns);
        }

        return $listModel;
    }

    public function getList($request,$objectClass)
    {
        $order = $request->get('order');
        $listModel = $objectClass::join('entitys',function($join) use($objectClass){
            $table = $objectClass::instance()->table;    
            $join->on($table.'.id', '=', 'entitys.id');
            $join->where('entitys.deleted', '=', 0);
        });
       
        
        if($order)
        {
          $by = Str::substr($order,0,1)==="-"?"DESC":"ASC";
          $order = $by==="DESC"?Str::substr($order,1):$order; 
          $listModel  = $listModel->orderBy($order,$by);  
        }
        
        return $listModel;
    }

    public function getCollumns($request,$objectModel)
    {
        $cvid = $request->get('cvid');
        if($cvid)
        {

        }else{
            if(isset($objectModel->columns_list))
            {
                $columns_list = $objectModel->columns_list;
            }
        }   
        return $columns_list;
    }

    public function getFieldSearch($columns)
    {
    	return $columns;
    }

    public function search($model,$keyword,$columns)
    {
        $keyword = preg_replace('!\s+!', ' ',preg_replace('/[^A-Za-z0-9ก-๙]/', ' ', $keyword));
        $searchGroup = explode(' ', $keyword);

        foreach ($searchGroup as $searchWord) {
            $model = $model->where(function($query) use($searchWord,$columns) {
                $fieldModelSearch = $this->getFieldSearch($columns);
                foreach ($fieldModelSearch as $fieldname) {    
                    $query = $query->orWhere($fieldname,"like","%{$searchWord}%");    
                }        
            });
        }                     
        return $model;
    }
}
