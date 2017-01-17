<?php 

namespace App\CC;

use File;
class Loader
{
	public static function getObjectClassName($name ,$objectName = "CC")
	{	
		$classNameTemp = "\\App\\Object\\%s\\%s";
		$fileNameTemp = base_path("app/Object/%s/%s.php");
		$fileNameFormat = str_replace("\\", "/", $name);
		$objects = [
			$objectName,
			"CC"
		];
		$handler = false;
		foreach($objects as $object)
		{
			$className = sprintf($classNameTemp,$object,$name);
			$filename = sprintf($fileNameTemp,$object,$fileNameFormat);
			if(File::exists($filename))
			{
				$handler = $className;
				break;
			}
		}
		if($handler)
		{
			return $handler;
		}else{
			throw new \Exception('Not found Handler');
		}
		
	}	

	public static function getObject($objectName)
	{
		return static::getObjectClassName($objectName,$objectName);
	}
}