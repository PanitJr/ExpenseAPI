<?php

namespace App\Object\Users;

use App\CC\Loader;
use App\Object\CC\CCEdit as Edit;
use App\CC\Error\ApiException;
use App\Object\Role\Role;

class CCEdit extends Edit
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
        return true;
    }

    public function convertLayout($objectModel)
    {
        $layout = [];
        $Object = $objectModel->getObject();
        
        $Blocks = $Object->getBlock()->orderby('sequence')->get();
        foreach ($Blocks as $Block) {
            $FieldsModel = $Block->getField();
            if(!empty($objectModel->id))
            {
                $FieldsModel
                ->whereNotIn('fieldname',[
                'password',
                'confirm_password',
                ]);
            }
            $Fields = $FieldsModel
                ->with('type')
                ->orderby('sequence')
                ->get();
            foreach ($Fields as $Field) {
                if($Field->fieldname == "role_id")
                {
                    $Field->Role = Role::all();
                }
            }
            $Block->fields = $Fields;
        }
        return $Blocks;
    }
}