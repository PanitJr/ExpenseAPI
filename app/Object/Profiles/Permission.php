<?php

namespace App\Object\Profiles;


use App\CC\ObjectBasic;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	public $table = 'permissions';
   	
    public $timestamps = false;

    public function object()
    {
        return $this->hasOne(ObjectBasic::class,'id','objectid');
    }
	
}


