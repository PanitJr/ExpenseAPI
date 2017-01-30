<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/30/2017
 * Time: 8:42 PM
 */

namespace App\Object\Item\ItemUtil;


use Illuminate\Database\Eloquent\Model;

class ItemStatus extends Model
{
    public $table = 'item_status';

    public $timestamps = false;
    public $object_name = "ItemStatus";

    public $columns_list = [
        'name'=>'name'
    ];
}