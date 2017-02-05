<?php

namespace App\Object\Leave;

use App\CC\Error\ApiException;
use App\CC\Loader;
use Exception;
use App\Object\CC\CCSave as saveAction;
class CCSave extends saveAction
{
    public function checkPermission($request)
    {
        return false;
    }

}
