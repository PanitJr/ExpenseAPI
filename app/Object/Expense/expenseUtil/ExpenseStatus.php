<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 9:35 PM
 */

namespace App\Object\Expense\expenseUtil;


use Illuminate\Database\Eloquent\Model;

class ExpenseStatus extends Model
{
    public $table = 'expense_status';

    public $timestamps = false;

    public $object_name = "ExpenseStatus";

}