<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CC\Loader;
use App\Http\Requests;
use stojg\crop\CropCenter;

class ImageController extends Controller
{
 	public function create(Request $Request,$objectName,$id,$field,$image_name)
 	{
 		$className = Loader::getObject($objectName);
 		$model = $className::find($id);
 		$image = $model->{$field};
		
		$imageexplore = explode("base64,",$image);
		if(count($imageexplore) == 2 )
		{
			$data = $imageexplore[1];
		}
		else
		{
			$fileImage = file_get_contents($image);
			$data = base64_encode($fileImage);
		}

		$imageblob = base64_decode($data);

		$imagick = new \Imagick();
		$imagick->readImageBlob($imageblob);
		$raw_width = $imagick->getImageWidth();
		$raw_height = $imagick->getImageHeight();
		$target_width = $Request->get("width",$raw_width);
		$target_height = $Request->get("height",$raw_height);
		$imagick->scaleImage($target_width, $target_height, true);
		//exit();
		ob_clean();
		header("Content-type: image/png");
		echo $imagick;
 	}  
}

