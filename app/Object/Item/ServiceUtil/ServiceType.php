<?php

/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/30/2017
 * Time: 8:32 PM
 */
namespace App\Object\Item\ServiceUtil;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    public $table = 'service_type';

    public $timestamps = false;
    public $object_name = "ServiceType";

    public $columns_list = [
        'name'=>'name'
    ];
}