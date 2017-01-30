<?php

/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/29/2017
 * Time: 12:13 AM
 */
namespace App\Object\Item\TravelUtil;
use Illuminate\Database\Eloquent\Model;

class TravelSubType extends Model
{
    public $table = 'travel_sub_type';

    public $timestamps = false;
    public $object_name = "TravelSubType";

    public $columns_list = [
        'name'=>'name'
    ];
}