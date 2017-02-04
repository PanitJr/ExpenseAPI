<?php

namespace App\Object\Expense;

use App\Object\CC\Entity;
use App\Object\Item\Item;
use Object\Expense\expenseUtil\Approve;
use Object\Expense\expnseUtil\ExpenseStatus;

class Expense extends Entity
{
	public $table = 'cc_expenses';
   	
    public $timestamps = false;

    public $object_name = "Expense";

    public $columns_list = [
    	'expense_name'=>'expensename'
    ];
    public function items(){
        return $this->hasMany(Item::class,'expense_id','id');
    }
    public function retriveStatus(){
        return $this->hasOne(ExpenseStatus::class,'id','status');
    }
    public function retriveApprove(){
        return $this->hasMany(Approve::class,'expense_id','id');
    }
}


