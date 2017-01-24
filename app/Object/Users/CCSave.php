<?php

namespace App\Object\Users;

use Hash;
use Validator;
use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCSave as Save;

class CCSave extends Save
{   
    public function process($request)
    {
        $objectName = $request->route('objectName');
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject($objectName);
		
		if(empty($record))
		{

	    	$objectModel = new $objectClass(); 
            $validateField = [
                'user_name' => 'required|unique:users',
                'email' => 'required|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ];
            
		}
		else
		{
			$objectModel = $objectClass::find($record); 
            $validateField = [
                'user_name' => 'required|unique:users,user_name,'.$record,
                'email' => 'required|unique:users,email,'.$record,
            ];
		}

        $validator = Validator::make($request->all(), $validateField);
        if ($validator->fails()) {
            $error = $validator->errors()->all();
            throw new ApiException('Varlidation Fail', implode('<br>',$error));            
        }

		return $this->saveValue($request,$objectModel);
    }

    public function saveValue($request,$objectModel)
    {
        $this->before_save($request,$objectModel);
        
        if($request->has('password') && $request->has('confirm_password'))
        {
            $objectModel->password = Hash::make($request->get('password'));
            $objectModel->confirm_password = Hash::make($request->get('confirm_password'));
        }
        
        $objectModel->save(); 
        
        $updateModel = $objectModel->find($objectModel->id);
        if($updateModel)
        {
            $this->after_save($request,$updateModel);
            $objectModel = $updateModel; 
        }
    
    	return $objectModel;
    }

}