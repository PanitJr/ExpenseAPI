<?php

namespace App\Object\Leave;

use App\CC\Loader;
use Illuminate\Support\Str;
use App\Object\CC\CCList as listAction;
class CCList extends listAction
{
    public function checkPermission($request)
    {
        return false;
    }
}
