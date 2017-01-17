<?php

namespace App\CC\Tool;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use App\CC\FieldBasic;
use App\CC\CCTrait\ToolInput;
use App\CC\CCSupport\Tool as ToolInterface;

class Field extends FieldBasic implements ToolInterface
{
    use ToolInput;

    protected $input =[
		"blockModel"=>null,
		"fieldname"=>null,
		"fieldlabel"=>null,
		"fieldtype"=>null
	];
	
	public function make()
	{
		$block=$this->getBlock();
		if($block)
		{
			$object = $block->getObject();
			$this->objectid = $object->getId();
			$this->fieldname = $this->getInput('fieldname');
			$this->fieldlabel = $this->getInput('fieldlabel');
			$this->sequence = $this->nextSequence($block);
			$this->blockid = $block->getId();
			$this->save();	
			if($this->getInput('fieldtype',false))
			{
				$fieldName = $this->getInput('fieldname');  
				$fieldType = $this->getInput('fieldtype');  
				Schema::table($object->tablename,function(Blueprint $table)use($fieldName,$fieldType)
				{		
					$table->$fieldType($fieldName);
				});
			}
		}else{
			throw new Exception('Not found Block');
		}			
	}

	public function remove()
	{
		$this->delete();
	}


	public function getBlock()
	{
		$blockModel = $this->getInput('blockModel',null);
		if(!$blockModel)
		{
			$blockModel = Block::find($this->blockid);
			$this->setInput("blockModel",$blockModel);
		}
		return $blockModel;
	}

	private function nextSequence($block)
	{
		$result = self::where('blockid',$block->getId())->max('sequence');
		return $result+1;
	}

}
