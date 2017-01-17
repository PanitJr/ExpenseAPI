<?php

namespace App\Object\Profile;

use App\CC\Error\ApiException;
use Illuminate\Database\Eloquent\Model;

class ObjectModel extends Model
{
	public $table = 'objects_model';
   	
    public $timestamps = false;

    public function permission()
    {
    	return $this->hasMany(Permission::class,'objectid');
    }

    public function hasPermission($profile_id = null)
    {
        $response = [];
        if(!$profile_id )
        {   
            if($this->pivot)
            {
                $profile_id = $this->pivot->profile_id;
            }
        }
        if($profile_id)
        {
            $response = ProfileObjectPermission::with('permission')
                ->where('object_id',$this->id)
                ->where('profile_id',$profile_id)
                ->get();
        }
        return $response;
    }

    public static function getModuleLayout()
    {
    	return ObjectModel::with('permission')->select(['label','id','name','icon'])->get();
    }
}


