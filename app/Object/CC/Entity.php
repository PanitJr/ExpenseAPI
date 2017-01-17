<?php

namespace App\Object\CC;

use App\CC\CCData\Entity as CCEntity;
use App\CC;
class Entity extends CCEntity
{
	protected $object;	

	public function getObject()
	{
		if(empty($this->object)){
			$this->object = CC\Object::getObjectEntity($this);
		}
		return $this->object;
	}
}
