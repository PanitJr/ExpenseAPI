<?php

namespace App\Object\Item;

use App\Object\CC\CCDetail as Detail;

class CCDetail extends Detail
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
