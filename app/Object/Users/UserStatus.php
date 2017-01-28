<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/27/2017
 * Time: 1:34 PM
 */

namespace App\Object\Users;


use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    public $table = 'user_status';

    public $timestamps = false;
}