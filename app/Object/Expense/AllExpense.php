<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/22/2017
 * Time: 10:14 PM
 */

namespace App\Object\Expense;


use App\CC\Loader;
use App\Object\CC\CCList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllExpense extends CCList
{
    public function checkPermission($request)
    {
        $accession=false;
        //Auth::loginUsingId(9);
        if (Auth::user()->role->name == 'Admin'){
            $accession = true;
        }
        return $accession;
    }
    public function process($request)
    {

        $objectClass =  Loader::getObject('Expense');

        /*$page = $request->get('limit',999999);

        $listModel = */

        $columns = $this->getCollumns($request,$objectClass::instance());

        /*$listModel = $this->filter($request,$listModel,$columns);

        $select = array_merge(["entitys.id"],$columns);*/

        $listFilters =$this->getFilters();

        $list = $this->getList($request,$objectClass);

        $total = $this->calTotal($list);
        $result=[
            'header' => $columns,
            'listInfo' => $list,
            'listFilters'=>$listFilters,
            'total_price'=> $total

        ];
        foreach ($result['listInfo'] as $index => $expense){
            $expense->retriveStatus;
            $expense->retriveOpportunity;
            $expense->entity;
        }
        return $result;
    }
    public function getList($request,$objectClass)
    {
        $order = $request->get('order');
        $listModel = $objectClass::join('entitys',function($join) use($objectClass,$request){
            $table = $objectClass::instance()->table;
            $join->on($table.'.id', '=', 'entitys.id');
            $join->where('entitys.deleted', '=', 0);
            if((int)$request->get('userPickList')['user'] != 0){$join->where('cc_expenses.user_id', '=', (int)$request->get('userPickList')['user']);}
            if((int)$request->get('userPickList')['Opp'] != 0){$join->where('cc_expenses.opportunity', '=', (int)$request->get('userPickList')['Opp']);}
            if((int)$request->get('userPickList')['status'] != 0){$join->where('cc_expenses.status', '=', (int)$request->get('userPickList')['status']);}
            if((int)$request->get('userPickList')['month'] != 0 && (int)$request->get('userPickList')['year']  !=0){
                $start = Carbon::create((int)$request->get('userPickList')['year'],(int)$request->get('userPickList')['month'])->startOfMonth()->toDateString();
                $end = Carbon::create((int)$request->get('userPickList')['year'],(int)$request->get('userPickList')['month'])->endOfMonth()->toDateString();
                $join->where('entitys.created_at','>',$start);
                $join->where('entitys.created_at','<',$end);
            }
        });

        if($order)
        {
            $by = Str::substr($order,0,1)==="-"?"DESC":"ASC";
            $order = $by==="DESC"?Str::substr($order,1):$order;
            $listModel  = $listModel->orderBy($order,$by);
        }

        $columns = $this->getCollumns($request,$objectClass::instance());
        $listModel = $this->filter($request,$listModel,$columns);
        $select = array_merge(["entitys.id"],$columns);
        $page = $request->get('limit',999999);


        return $listModel->paginate($page,$select);
    }
    public function getFilters(){
        $userlis = DB::table('users')->select('id','user_name')->get();
        $opplis = DB::table('cc_opportunitys')->select('id','name')->where('active',1)->get();
        $statuslis = DB::table('expense_status')->get();
        $filters=[
            'userlis'=>$userlis,
            'opplis'=>$opplis,
            'statuslis'=>$statuslis
        ];
        return $filters;
    }
    public function calTotal($list){
        $total = 0;
        foreach ($list as $expense){
            $total+=$expense->total_price;
        }
        return $total;
    }
}