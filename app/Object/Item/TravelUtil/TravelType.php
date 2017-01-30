<?php

/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/29/2017
 * Time: 12:12 AM
 */
namespace App\Object\Item\TravelUtil;
use Illuminate\Database\Eloquent\Model;

class TravelType extends Model
{
    public $table = 'travel_type';

    public $timestamps = false;
    public $object_name = "TravelType";

    public $columns_list = [
        'name'=>'name'
    ];
}