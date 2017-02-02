<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/28/2017
 * Time: 11:46 PM
 */

namespace App\Object\Item;


use App\Object\Item\ServiceUtil\ServiceType;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $table = 'services';

    public $timestamps = false;

    public function type(){
        return $this->hasOne(ServiceType::class,'id','type');
    }
}