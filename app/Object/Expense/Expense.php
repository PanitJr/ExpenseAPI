<?php

namespace App\Object\Expense;

use App\Object\CC\Entity;
use App\Object\Item\Item;
use App\Object\Expense\expenseUtil\Approve;
use App\Object\Expense\expenseUtil\ExpenseStatus;
use App\Object\Opportunity\Opportunity;
use App\Object\Users\Users;

class Expense extends Entity
{
	public $table = 'cc_expenses';
   	
    public $timestamps = false;

    public $object_name = "Expense";

    public $columns_list = [
    	'expense_name'=>'expensename',
        'Opportunity'=>'opportunity',
        'Status'=>'status',
        'Total Price'=>'total_price'
    ];
    public function items(){
        return $this->hasMany(Item::class,'expense_id','id');
    }
    public function retriveStatus(){
        return $this->hasOne(ExpenseStatus::class,'id','status');
    }
    public function retriveApprove(){
        return $this->hasMany(Approve::class,'expense','id');
    }
    public function retriveOpportunity(){
        return $this->hasOne(Opportunity::class,'id','opportunity');
    }
    public function User(){
        return $this->hasOne(Users::class,'id','user_id');
    }
    public function retriveApprover(){
        return $this->hasOne(Users::class,'id','approver');
    }
}


