<?php

namespace App\Object\Users;

use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCSave as Save;
use Illuminate\Support\Facades\Validator;

class CCSave extends Save
{
    public function checkPermission($request)
    {
        $permission=false;
        //Auth::loginUsingId(9);
        $record = (int)$request->route('record');
        if(!empty($record)){
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'create' && $permission->objectid == '5'){
                        $permission = true;
                    }
                }
            }
        }
        if (Auth::user()->id == $record ){
            $permission = true;
        }if (Auth::user()->role->name == 'Admin'){
            $permission = true;
        }
        return $permission;
    }
    public function process($request)
    {
        $objectName = $request->route('objectName');
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject($objectName);
        $validateField=null;
		if(empty($record))
		{
	    	$objectModel = new $objectClass(); 
            $validateField = [
                'user_name' => 'required|unique:users',
                'email' => 'required|unique:users'
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
        //var_dump($request->all());
        $validator = Validator::make([
                'user_name'=>$request->get('user_name'),
                'email'=>$request->get('email')]
            , $validateField);
        if ($validator->fails()) {
            $error = $validator->errors()->all();
            var_dump($error);
            throw new ApiException('Varlidation Fail', implode('<br>',$error));

        }

		return $this->saveValue($request,$objectModel);
    }

    public function saveValue($request,$objectModel)
    {
        $this->before_save($request,$objectModel);
        $record = (int)$request->route('record');
        if($request->has('password') && $request->has('confirm_password'))
        {
            $objectModel->password = Hash::make($request->get('password'));
            $objectModel->confirm_password = Hash::make($request->get('confirm_password'));
        }

        $objectModel->save();

        $updateModel = $objectModel->find($objectModel->id);
        if(empty($record)){
            DB::table('user_profile')->insert(['user_id'=>$updateModel->id,'profile_id'=>$request->get('profiles_id')]);
        }
        else{
            DB::table('user_profile')
                ->where('user_id', $record)
                ->update(['profile_id' => $request->get('profiles_id')]);
        }
    
    	return $objectModel;
    }
    public function after_save($request,$objectModel)
    {
        return $objectModel;
    }

}
