<?php

namespace App\Object\Item;

use App\CC\Loader;
use Illuminate\Support\Str;
use App\Object\CC\CCList as CList;
class CCList extends CList
{
    public function checkPermission($request)
    {
        return true;
    }
    
    public function process($request)
    {
        return parent::process($request);

    }

}
