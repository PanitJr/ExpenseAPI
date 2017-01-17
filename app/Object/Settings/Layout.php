<?php

namespace App\Object\Settings;

use App\CC\Loader;
use App\CC\Error\ApiException;

class Layout
{
	public function __construct($objectModel = null)
	{
		$this->objectModel = $objectModel;
	}

    public function getLayout()
    {
    	$layout = [];
    	$Object = $this->objectModel->getObject();
    	$Blocks = $Object->getBlock()->orderby('sequence')->get();
    	foreach ($Blocks as $Block) {
			$Fields = $Block->getField()->orderby('sequence')->get();
			$Block->fields = $Fields;
    	}
    	return $Blocks;
    }
}
