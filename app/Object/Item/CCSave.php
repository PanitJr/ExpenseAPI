<?php

namespace App\Object\Item;

use App\CC\Loader;
use App\Object\CC\CCSave as CSave;
use Illuminate\Support\Facades\Auth;

class CCSave extends CSave
{
    public function checkPermission($request)
    {
        return true;
    }

    public function process($request)
    {
        $result = parent::process($request);
        $record = (int)$request->route('record');
        if(empty($record)){
            if((int)$request->get('category')==1){
                $travel = new Travel();
                $travel->item_id = $result->id;
                $travel->save();
            }else if((int)$request->get('category')==2){
                $service = new Service();
                $service->item_id = $result->id;
                $service->save();
            }else if((int)$request->get('category')==3){
                $medical = new Medical();
                $medical->item_id = $result->id;
                $medical->save();
            }else if((int)$request->get('category')==4){
                $other = new Other();
                $other->item_id = $result->id;
                $other->save();
            }
        }else{
            if((int)$request->get('category')==1){
                $travel = $result->travel;
                $travel->item_id = $result->id;
                $travel->save();
            }else if((int)$request->get('category')==2){
                $service = $result->service;
                $service->item_id = $result->id;
                $service->save();
            }else if((int)$request->get('category')==3){
                $medical = $result->medical ;
                $medical->item_id = $result->id;
                $medical->save();
            }else if((int)$request->get('category')==4){
                $other = $result->other;
                $other->item_id = $result->id;
                $other->save();
            }
        }
        return $result;
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
        $objectModel->itemname = Auth::user()->user_name."-Item-".$objectModel->id;
        $objectModel->save();
    }
}
