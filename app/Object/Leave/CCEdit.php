<?php

namespace App\Object\Leave;

use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCEdit as editAction;
class CCEdit extends editAction
{
    public function checkPermission($request)
    {
        $objectName = $request->route('objectName');
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject($objectName);
        $objectModel = $objectClass::find($record);

        $error_code = "ACCESS_DENIED";

        if(!$objectModel && !empty($record))
        {
            throw new ApiException($error_code, 'Record not found ! ');
        }

        if($objectModel && $objectModel->entity->deleted ==1)
        {
            throw new ApiException($error_code, 'The record you are trying to view has been deleted.');
        }
        return false;
    }

}