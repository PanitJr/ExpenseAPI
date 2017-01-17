<?php

namespace App\CC\CCTrait;

trait ToolInput
{	
	public function input($array)
	{
		foreach ($array as $key => $value) {		
			$this->setInput($key,$value);
		}
		return $this;
	}
		
	public function setInput($name,$value)
	{
		$this->input[$name] = $value;
	}

	public function getInput($name,$withOutValue=null)
	{
		return isset($this->input[$name])?$this->input[$name]:$withOutValue;
	}

	public function inputEmpty()
	{
		return empty($this->input)?:!array_first($this->input,function($key,$value){
			return !is_null($value);
		});
	}
}