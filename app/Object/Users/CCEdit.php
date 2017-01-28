<?php

namespace App\Object\Users;

use App\CC\Loader;
use App\Object\CC\CCEdit as Edit;
use App\CC\Error\ApiException;
use App\Object\Profiles\Profiles;
use App\Object\Role\Role;
use Illuminate\Support\Facades\Auth;

class CCEdit extends Edit
{

    public function checkPermission($request)
    {
        $objectName = $request->route('objectName');
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject($objectName);
        $objectModel = $objectClass::find($record);

        $error_code = "ACCESS_DENIED";

        $permission=false;
        //Auth::loginUsingId(9);
        $record = (int)$request->route('record');
        if(empty($record)){
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'create' && $permission->objectid == '5'){
                        $permission = true;
                        break;
                    }
                }
            }
        }else if (Auth::user()->id == $record && !empty($record) ){
            $permission = true;
        }


        if(!$objectModel && !empty($record))
        {
            throw new ApiException($error_code, 'Record not found ! ');
        }

        if($objectModel && $objectModel->entity->deleted ==1)
        {
            throw new ApiException($error_code, 'The record you are trying to view has been deleted.');
        }
        return $permission;
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
//                $FieldsModel
//                ->whereNotIn('fieldname',[
//                'password',
//                'confirm_password',
//                ]);
            }
            $Fields = $FieldsModel
                ->with('type')
                ->orderby('sequence')
                ->get();
            foreach ($Fields as $Field) {
                if($Field->fieldname == "role_id")
                {
                    $Field->Role = Role::all();
                    $Field->Profile = Profiles::all();
                }
                if($Field->fieldname == "status")
                {
                    $Field->status = UserStatus::all();
                }
                if($Field->fieldname == "supervisor_id")
                {
                    $Field->supervisor = Users::all();
                }
            }
            $Block->fields = $Fields;
        }
        return $Blocks;
    }
}