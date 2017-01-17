<?php

namespace App\Object\DocumentTemplate;

use App\CC\Loader;
use App\Object\CC\CCSave as Save;
class CCSave extends Save
{
	private $docxPath = "app/docx";

   	public function process($request)
    {

        $response = parent::process($request);
        $this->fileUpdate($request,$response);


        return $response;
    }


    public function fileUpdate($request , $object)
    {
        $fieldName = 'file_template';
        if ($request->hasFile($fieldName)) {
            $pathName = storage_path(sprintf('%s/%s',$this->docxPath , $object->id));
            $filename  = $object->id . '.docx';
            $file = $request->file($fieldName);
            $file->move($pathName,$filename);
            $object->{$fieldName} = url( "Doc/file/".$object->id."/". $filename);
            $object->save();
        }
    }

}
