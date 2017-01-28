<?php

namespace App\Object\Item;

use App\Object\CC\CCEdit as Edit;

class CCEdit extends Edit
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