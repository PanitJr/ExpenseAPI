<?php

namespace App\CC\Tool;

use Schema;
use File;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use App\CC\ObjectBasic;
use App\CC\CCTrait\ToolInput;
use App\CC\CCSupport\Tool as ToolInterface;


class Object extends ObjectBasic implements ToolInterface
{
	use ToolInput;

	protected $input =[
		"objectname"=>null,
		"fieldname"=>null,
		"fieldlabel"=>null,
		"entityidfield"=>null
	];
 	
 	public function make()
	{

		$this->cleanInput();
		if(!$this->checkDuplicateName($this->getInput('objectname')))
		{	
			$this->insertObject();	
			$this->createTable();
			$this->makeModelObject();
			return $this;
		}else{
			throw new \Exception('Object Name is Duplicate');	
		}
	}  

	public function remove()
	{
		$this->removeModelObject();
		$this->dropTable();
		$this->delete();
		return $this;
	} 

	private function cleanInput()
	{
		if(!empty($this->input['objectname']))
		{
			$this->input['fieldlabel'] = $this->getInput('fieldlabel',
				sprintf('%s Name',$this->input['objectname']));
			$this->input['fieldname'] = $this->getInput('fieldname',
				Str::lower(Str::studly($this->input['fieldlabel'])));
		}else{
			throw new \Exception('require objectname for CreateObject');
		}
	}

	private function insertObject()
	{
		$tableName = sprintf("cc_%ss",Str::lower($this->getInput("objectname")));
		$this->name	= $this->getInput('objectname');
		$this->label	= $this->getInput('objectname');
		$this->tablename = $tableName;	
		$this->fieldname = $this->getInput('fieldname');	
		$this->save();	

		$block = new Block();	
		$block->input([
			"blocklabel"=>sprintf("%s Information",$this->name)
		]);
		$this->addBlock($block);

		$field = new Field();
		$field->input([
			"fieldname"=>$this->fieldname,
			"fieldlabel"=>$this->getInput('fieldlabel')
		]);
		$block->addField($field);
		
		$filter = new Filter();
		$filter->input([
			"viewname"=>"All",
			"isdefault"=>true,
		]);
		$this->addFilter($filter);

		$filter->addField($field);
	}

	
	private function createTable()
	{
		$thisobject = $this;
		Schema::create($thisobject->tablename, function (Blueprint $table) use ($thisobject) {
            $table->integer('id');
            $table->string($this->fieldname);
            $table->primary('id');
        });
//        Schema::table('permissions', function ($table) use ($thisobject) {
//            $table->boolean('create'.$thisobject->getInput('objectname'))->nullable();
//            $table->boolean('update'.$thisobject->getInput('objectname'))->nullable();
//            $table->boolean('delete'.$thisobject->getInput('objectname'))->nullable();
//            $table->boolean('read'.$thisobject->getInput('objectname'))->nullable();
//        });
	}

	private function dropTable()
	{
		Schema::drop($this->tablename);
	}	

	private function makeModelObject()
	{
		$pathModel = app_path('Object/'.$this->name);
		if(!File::exists($pathModel)){
			File::makeDirectory($pathModel,0775);	
			
			$ObjectFileContent = File::get(__dir__."/../ObjectV/v1/Object.php");
			$replacevars = array(
				'ObjectName'   => $this->name,
				'<<tablename>>'   => $this->tablename,
				'<<field_name>>'   => $this->fieldname,
				'<<field_label>>'   => $this->getInput('fieldlabel')
			);

			foreach ($replacevars as $key => $value) {
				$ObjectFileContent = str_replace($key, $value, $ObjectFileContent);
			}
			$file = sprintf("%s/%s.php",$pathModel,$this->name);
			File::put($file, $ObjectFileContent);	
		}else{
			throw new \Exception('Object File Exists');
		}
	}

	private function removeModelObject()
	{
		$pathModel = app_path('Object/'.$this->name);
		if(File::exists($pathModel)){
			File::cleanDirectory($pathModel);
			rmdir($pathModel);
		}

	}

	private function checkDuplicateName($name)
	{
		return self::where("name",$name)->count();
	}

	public function addBlock($blockTool)
	{	
		$blockTool->setInput("objectModel",$this);
		$blockTool->make();
	}

	public function addFilter($filter)
	{
		$filter->setInput("objectModel",$this);
		$filter->make();
	}
}	
