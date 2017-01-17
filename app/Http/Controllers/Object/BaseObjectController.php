<?php

namespace App\Http\Controllers\Object;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\apiResponse;
use App\CC\Error\ApiException;

class BaseObjectController extends ApiController
{
    public static function run($handler,Request $Request)
    {
        try{
            if($handler->checkPermission($Request))
            {
                $result =  $handler->process($Request);    
                return apiResponse::success($result);    
            }
            else
            {
                throw new ApiException("ACCESS_DENIED", 'Access denied for current process !');
            }
        }
        catch(ApiException $e){
            return apiResponse::error($e->error_code,$e->error);
        }   
    }
}
