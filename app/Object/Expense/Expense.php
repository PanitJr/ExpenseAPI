<?php

namespace App\Object\Expense;

use App\Object\CC\Entity;

class Expense extends Entity
{
	public $table = 'cc_expenses';
   	
    public $timestamps = false;

    public $object_name = "Expense";

    public $columns_list = [
    	'expense_name'=>'expensename'
    ];
}


