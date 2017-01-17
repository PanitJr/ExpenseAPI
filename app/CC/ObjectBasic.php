<?php

namespace App\CC;

use Illuminate\Database\Eloquent\Model;

class ObjectBasic extends Model
{
    protected $table = 'objects_model';

    public $timestamps = false;

    public function getId()
    {
    	return $this->id;
    }

    public function getBlock()
    {
        return $this->hasMany(Block::class,'objectid');
    }

    public function getField()
    {
        return $this->hasMany(Field::class,'objectid');
    }

}
