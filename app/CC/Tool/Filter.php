<?php

namespace App\CC\Tool;

use Illuminate\Support\Str;
use App\CC\Filter as FilterModel;
use App\CC\CCTrait\ToolInput;
use App\CC\CCSupport\Tool as ToolInterface;

class Filter extends FilterModel implements ToolInterface
{
    use ToolInput;

	protected $input =[
		"viewname"=>null,
		"isdefault"=>null,
		"objectModel"=>null,
	];
	
	public function make()
	{
		$object =$this->getObject();
		if($object)
		{
			$this->objectid = $object->getId();
			$this->viewname = $this->getInput('viewname');
			$this->setdefault = $this->getInput('isdefault');
			$this->save();
		}else{
			throw new Exception('Not found Object Model');
		}	
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

	public function remove()
	{
		$this->delete();
	}

	public function addField($Field,$columnindex=0)
	{
		\DB::table('customview_columnslist')->insert([
			"columnname"=>$Field->fieldname,
			"columnindex"=>$columnindex,
			"cvid"=>$this->id
		]);
	}
}
