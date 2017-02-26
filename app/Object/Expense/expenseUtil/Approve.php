<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 2/4/2017
 * Time: 5:21 PM
 */

namespace App\Object\Expense\expenseUtil;


use App\Object\Users\Users;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    public $table = 'approves';

    public $timestamps = false;

    public $object_name = "Approve";

    public function status(){
        return $this->hasOne(ApproveAction::class,'id','action');
    }
    public function retrieveUser(){
        return $this->hasOne(Users::class,'id','user');
    }
}
