<?php

namespace App\CC\Tool;

use Illuminate\Support\Str;
use App\CC\Block as BlockModel;
use App\CC\CCTrait\ToolInput;
use App\CC\CCSupport\Tool as ToolInterface;

class Block extends BlockModel implements ToolInterface
{
    use ToolInput;

	protected $input =[
		"blocklabel"=>null,
		"objectModel"=>null
	];
	
	public function make()
	{
		$object =$this->getObject();
		if($object)
		{
			$this->objectid = $object->getId();
			$this->blocklabel = $this->getInput('blocklabel');
			$this->sequence = $this->nextSequence($object);
			$this->save();
		}else{
			throw new Exception('Not found Object Model');
		}	
	}

	public function remove()
	{
		$this->delete();
	}

	public function getObject()
	{
		$objectModel = $this->getInput('objectModel',null);
		if(!$objectModel)
		{
			$objectModel = Object::find($this->objectid);
			$this->setInput("objectModel",$objectModel);
		}
		return $objectModel;
	}

	private function nextSequence($object)
	{
		$result = self::where('objectid',$object->getId())->max('sequence');
		return $result+1;
	}

	public function addField($field)
	{
		$field->setInput('blockModel',$this);
		return $field->make();
	}
}
