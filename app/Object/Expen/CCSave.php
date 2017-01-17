<?php

namespace App\Object\Expen;

use App\CC\Loader;
use App\Object\CC\CCSave as Save;

class CCSave extends Save
{
    public function checkPermission($request)
    {
        return true;
    }
    
    public function process($request)
    {
        $price = $request->get('price');
        $model = parent::process($request);
        $model->save();
        return $model; 
    }

}
