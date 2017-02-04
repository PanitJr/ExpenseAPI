<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/28/2017
 * Time: 11:45 PM
 */

namespace App\Object\Item;


use App\Object\Item\TravelUtil\TravelSubType;
use App\Object\Item\TravelUtil\TravelType;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    public $table = 'travels';

    public $timestamps = false;

    public function travelType(){
        return $this->hasOne(TravelType::class,'id','travel_type');
    }
    public function travelSubType(){
        return $this->hasOne(TravelSubType::class,'id','travel_sub_type');
    }

}