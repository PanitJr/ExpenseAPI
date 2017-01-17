<?php

namespace App\CC;

class Object extends ObjectBasic
{
	protected $entity = null;

	public function setEntity($entity)
	{
		$this->entity = $entity;
		return $this;
	}

	public function getEntity()
	{
		return $this->entity;
	}	

	public static function getObjectEntity(\App\Object\CC\Entity $entity)
	{	
		return self::where('name',$entity->object_name)->first()->setEntity($entity);
	}
}
