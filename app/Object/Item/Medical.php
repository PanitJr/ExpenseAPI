<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/28/2017
 * Time: 11:45 PM
 */

namespace App\Object\Item;


use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    public $table = 'cc_items';

    public $timestamps = false;
}