<?php

namespace App\CC;

use Illuminate\Database\Eloquent\Model;

class FieldBasic extends Model
{
    protected $table = 'object_field';

    public $timestamps = false;

    public function getId()
    {
    	return $this->id;
    }

    public function type()
    {
    	return $this->hasOne(FieldTypeBasic::class,'id', 'type');
    }
}
