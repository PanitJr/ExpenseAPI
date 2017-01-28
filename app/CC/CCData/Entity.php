<?php

namespace App\CC\CCData;

use Illuminate\Support\Facades\Auth;
use App\CC;
use Illuminate\Database\Eloquent\Model;
use App\CC\CCTrait\DefaultEntity;

class Entity extends Model
{
	use DefaultEntity;

	public function save(array $options = [])
	{
		$id = $this->entity_save();
		$save = parent::save($options);
		$this->id = $id;
		return $save;
	}


	public function delete()
	{
		if(!is_null($this->getId()))
		{
			$EntityData = $this->EntityData();
			$EntityData->deleted = 1;
			$EntityData->save();
			return true;
		}
		return false;
	}

	public function confirm_delete()
	{
		return parent::delete();
	}

	public function entity()
	{
		return $this->hasOne(EntityData::class,'id');
	}

	public function EntityData() {
		$id = $this->getId();
	    return EntityData::find($id);
	}

	public function entity_save()
	{

		if(is_null($this->getId()))
		{
			$EntityData = new EntityData();
			$EntityData->ownerid = Auth::user()->id;
			$EntityData->createid = Auth::user()->id;
			$EntityData->deleted = 0;
			$EntityData->label = $this->getLabel();
			$EntityData->save();
			$this->id = $EntityData->getId();
		}
		else
		{
			$EntityData = EntityData::find($this->getId());
			$EntityData->modifiedby = Auth::user()->id;
			$EntityData->label = $this->getLabel();
			$EntityData->save();	
		}
		return $EntityData->getId();
	}

	public function getLabel()
	{
		$object = CC\ObjectBasic::where("name",$this->object_name)->first();
		$label = "";
		if($object)
		{
			$label = $this->object_name;
		}
		return $label;
	}

	public static function instance()
	{
		return new static();
	}
}
