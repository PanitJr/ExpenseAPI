<?php

namespace App\Http\Controllers\Object;

use File;
use App\CC\Loader;
use Illuminate\Http\Request;
use App\apiResponse;
use App\CC\Error\ApiException;

class BrandController extends BaseObjectController
{
    private $objectName = "Brand";

    public function importBrandOption(Request $request)
    {
        try{
            $className = Loader::getObjectClassName('Import\ImportBrandOptionFileAdvance',
                $this->objectName);
            $handler = new $className();
            
            $result = $handler->process($request->all());
            return apiResponse::success($result);
        }
        catch(ApiException $e){
            return apiResponse::error($e->error_code,$e->error);
        }
    }
}
