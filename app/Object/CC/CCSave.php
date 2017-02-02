<?php

namespace App\Object\CC;

use App\CC\Error\ApiException;
use App\CC\Loader;
use Exception;

class CCSave
{
    public function checkPermission($request)
    {
        return true;
    }
    
    public function process($request)
    {
    	$objectName = $request->route('objectName');
    	$record = (int)$request->route('record');
    	$objectClass = 	Loader::getObject($objectName);
		
		if(empty($record))
		{

	    	$objectModel = new $objectClass(); 
		}
		else
		{
			$objectModel = $objectClass::find($record); 
		}    
		return $this->saveValue($request,$objectModel);
    }

    public function saveValue($request,$objectModel)
    {
        $this->before_save($request,$objectModel);
    	
        $objectModel->save(); 
        
        $updateModel = $objectModel->find($objectModel->id);
        if($updateModel)
        {
            $this->after_save($request,$updateModel);
            $objectModel = $updateModel; 
        }
        

    	return $objectModel;
    }

    public function getObject($objectModel)
    {
        return $objectModel->getObject();
    }

    public function before_save($request,$objectModel)
    {
        $Object = $this->getObject($objectModel);
        foreach ($Object->getField as $field) {
            try{
            $fieldValue = $request->get($field->fieldname);
            }catch (Exception $e){
                throw new ApiException('Error On Requested', 'Request doesnt match ! ');
            }
            if(!is_null($fieldValue))
            {
                $objectModel->{$field->fieldname} = $fieldValue;    
            }
        }
    }

    public function after_save($request,$objectModel)
    {
        $Object = $this->getObject($objectModel);
        foreach ($Object->getField as $field) {
            $fieldValue = $this->coverdataAfterSave($request,$field,$objectModel);
            if(!is_null($fieldValue))
            {
                $objectModel->{$field->fieldname} = $fieldValue;    
            }
        }
        $objectModel->save();
    }

    public function coverdataAfterSave($request , $field , $objectModel)
    {
        $response = null;
        switch ($field->get_fieldType()) {
            case 'image':
                $response = $this->imageUpload($request,$field->fieldname,$objectModel);
                break;
        }
        return $response;
    }

    public function imageUpload($request,$name,$objectModel)
    {   
        $response = null;
        $pathName = sprintf("object_image/%s/%s/",class_basename($objectModel),$objectModel->id);
        $filePath = $request->get($name,null);
        if ($request->hasFile($name)) {
            $image = $request->file($name);
            $filename  = $name . '.png';
            $response = $this->fileUpload($request,$name,$filename,$pathName);   
            $response .= sprintf("?%s",md5($image));
        }
        else if(empty($filePath))
        {
            $response = "";  
        }
        return $response;        
    }

    public function fileUpload($request,$name,$filename,$pathName)
    {
        $response = null;
        if ($request->hasFile($name)) {
            $file = $request->file($name);
            $file->move(public_path($pathName),$filename);
            $response = asset($pathName.$filename);
        }
        return $response;
        
    }
}
