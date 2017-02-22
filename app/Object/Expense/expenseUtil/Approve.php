<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 5:21 PM
 */

namespace App\Object\Expense\expenseUtil;


use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    public $table = 'approves';

    public $timestamps = true;

    public $object_name = "Approve";

    public function status(){
        return $this->hasOne(ApproveAction::class,'id','action');
    }
}
