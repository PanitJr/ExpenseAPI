<?php

namespace App\CC;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
  	protected $table = 'object_block';

    public $timestamps = false;

    public function getId()
    {
    	return $this->id;
    }

    public function getField()
    {
        return $this->hasMany(Field::class,'blockid');
    }
}
