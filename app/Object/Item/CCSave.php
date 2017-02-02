<?php

namespace App\Object\Item;

use App\CC\Loader;
use App\Object\CC\CCSave as CSave;
use Illuminate\Support\Facades\Auth;

class CCSave extends CSave
{
    public function checkPermission($request)
    {
        $permission=false;
        //Auth::loginUsingId(9);
        $record = (int)$request->route('record');
        if(!empty($record)){
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'edit' && $permission->objectid == '8'){
                        $permission = true;
                    }
                }
            }
        }
        else if (Auth::user()->role->name == 'Admin'){
            $permission = true;
        }
        return $permission;
    }

    public function process($request)
    {
        $result = parent::process($request);
        $record = (int)$request->route('record');
        if(empty($record)){
            if((int)$request->get('category')==1){
                $request->route('travel');
                $travel = new Travel();
                $travelreq = $request->get('data')['travel'];
                $travel->item_id = $result->id;
                $travel->travel_type = $travelreq['travel_type'];
                $travel->travel_sub_type = $travelreq['travel_sub_type'];
                $travel->destination = $travelreq['destination'];
                $travel->origination = $travelreq['origination'];
                $travel->save();
            }else if((int)$request->get('category')==2){
                $service = new Service();
                $service->item_id = $result->id;
                $servicereq = $request->get('data')['service'];
                $service->name = $servicereq['name'];
                $service->type = $servicereq['type'];
                $service->save();
            }else if((int)$request->get('category')==3){
                $medical = new Medical();
                $medical->item_id = $result->id;
                $medicalreq = $request->get('data')['medical'];
                $medical->symptom_name = $medicalreq['symptom_name'];
                $medical->hospital = $medicalreq['hospital'];
                $medical->save();
            }else if((int)$request->get('category')==4){
                $other = new Other();
                $other->item_id = $result->id;
                $otherreq = $request->get('data')['other'];
                $other->topic = $otherreq['topic'];
                $other->save();
            }
        }else{
            if((int)$request->get('category')==1){
                $travel = $result->travel;
                $travelreq = $request->get('data')['travel'];
                $travel->item_id = $result->id;
                $travel->travel_type = $travelreq['travel_type'];
                $travel->travel_sub_type = $travelreq['travel_sub_type'];
                $travel->destination = $travelreq['destination'];
                $travel->origination = $travelreq['origination'];
                $travel->save();
            }else if((int)$request->get('category')==2){
                $service = $result->service;
                $service->item_id = $result->id;
                $servicereq = $request->route('data')['service'];
                $service->name = $servicereq['name'];
                $service->type = $servicereq['type'];
                $service->save();
            }else if((int)$request->get('category')==3){
                $medical = $result->medical ;
                $medical->item_id = $result->id;
                $medical->item_id = $result->id;
                $medicalreq = $request->get('data')['medical'];
                $medical->symptom_name = $medicalreq['symptom_name'];
                $medical->hospital = $medicalreq['hospital'];
                $medical->save();
            }else if((int)$request->get('category')==4){
                $other = $result->other;
                $other->item_id = $result->id;
                $otherreq = $request->get('data')['other'];
                $other->topic = $otherreq['topic'];
                $other->save();
            }
        }
        return $result;
    }
    public function saveValue($request,$objectModel)
    {
        $this->before_save($request,$objectModel);

        $objectModel->save();

        $updateModel = $objectModel->find($objectModel->id);
        $updateModel->itemname = Auth::user()->user_name."-Item-".$objectModel->id;
        if($updateModel)
        {
            $this->after_save($request,$updateModel);
            $objectModel = $updateModel;
        }
        return $objectModel;
    }
    public function before_save($request,$objectModel)
    {
        $Object = $this->getObject($objectModel);
        foreach ($Object->getField as $field) {
            $fieldValue = $request->get($field->fieldname);
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
}
