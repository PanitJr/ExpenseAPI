<?php

namespace App\Object\Profiles;

use App\CC\ObjectBasic;
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
        foreach ($objectModel->getPermission as $per)
            $per->object;
        return $objectModel;
    }
}
