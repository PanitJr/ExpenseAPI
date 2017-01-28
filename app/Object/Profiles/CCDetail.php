<?php

namespace App\Object\Profiles;

use \App\Object\CC\CCDetail as detail;
class CCDetail extends detail
{
    public function checkPermission($request)
    {
        return true;
    }


    public function convertData($objectModel)
    {
        $objectModel->getPermission;
        return $objectModel;
    }
}
