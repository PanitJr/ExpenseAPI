<?php

/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/29/2017
 * Time: 12:10 AM
 */
namespace App\Object\Item\ItemUtil;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    public $table = 'item_category';

    public $timestamps = false;
    public $object_name = "ItemCategory";

    public $columns_list = [
        'name'=>'name'
    ];
}