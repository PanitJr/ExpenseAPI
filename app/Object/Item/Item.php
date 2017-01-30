<?php

namespace App\Object\Item;

use App\Object\CC\Entity;
use App\Object\Expense\Expense;
use App\Object\Item\ItemUtil\ItemCategory;
use App\Object\Opportunity\Opportunity;

class Item extends Entity
{
	public $table = 'cc_items';
   	
    public $timestamps = false;

    public $object_name = "Item";

    public $columns_list = [
    	'item_name'=>'itemname'
    ];
//    public function getLabel()
//    {
//        return sprintf("%s %s",$this->object_name,$this->category);
//    }
    public function travel(){
        return $this->hasOne(Travel::class,'item_id','id');
    }
    public function service(){
        return $this->hasOne(Service::class,'item_id','id');
    }
    public function other(){
        return $this->hasOne(Other::class,'item_id','id');
    }
    public function medical(){
        return $this->hasOne(Medical::class,'item_id','id');
    }
    public function expense(){
        return $this->hasOne(Expense::class,'id','expense_id');
    }
    public function Opportunity(){
        return $this->hasOne(Opportunity::class,'id','opportunity');
    }
    public function Category(){
        return $this->hasOne(ItemCategory::class,'id','category');
    }
}


