<?php

namespace App\Http\Controllers\Object\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\apiResponse;
use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\Settings\Layout;

class LayoutController extends ApiController
{
    
    public function objectAll(Request $request)
    {
    	$objectAll = \App\CC\ObjectBasic::all();
        return apiResponse::success($objectAll); 	
    }

    public function object(Request $request)
    {	
    	$objectName = $request->route('objectName');
    	$className = Loader::getObject($objectName);
    	$layout = new Layout(new $className());
    	return apiResponse::success($layout->getLayout());
    }
}