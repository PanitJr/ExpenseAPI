<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 5:39 PM
 */

namespace Object\Expense\expenseUtil;


use Illuminate\Database\Eloquent\Model;

class ApproveAction extends Model
{
    public $table = 'approve_action';

    public $timestamps = false;

    public $object_name = "ApproveAction";
}