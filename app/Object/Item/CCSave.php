<?php

namespace App\Object\Item;

use App\CC\Loader;
use App\Object\CC\CCSave as CSave;
use App\Object\Item\TravelUtil\AirportLink;
use App\Object\Item\TravelUtil\BRT;
use App\Object\Item\TravelUtil\BTS;
use App\Object\Item\TravelUtil\MRT;
use Illuminate\Support\Facades\Auth;

class CCSave extends CSave
{
    public function checkPermission($request)
    {
        $accession=false;
        //Auth::loginUsingId(9);
        $record = (int)$request->route('record');
        if(!empty($record)){
            foreach (Auth::user()->profiles as $profile){
                foreach ($profile->getPermission as $permission){
                    if($permission->name == 'edit' && $permission->objectid == '8'){
                        $accession = true;
                    }
                }
            }
        }
        if (Auth::user()->role->name == 'Admin'){
            $accession = true;
        }
        return $accession;
    }

    public function process($request)
    {
        $result = parent::process($request);
        $record = (int)$request->route('record');
        if(empty($record)){
            if((int)$request->get('category')==1){
                $travel = new Travel();
                $travelreq = $request->get('travel');
                $travel->item_id = $result->id;
                $travel->travel_type = $travelreq['traveltype'];
                if($travelreq['traveltype'] == 1) {
                    $travel->travel_sub_type = $travelreq['travelsubtype'];
                }
                $travel->destination = $travelreq['destination'];
                $travel->origination = $travelreq['origination'];
                if(!empty($travelreq['travelsubtype'])) {
                    if ($travelreq['travelsubtype'] == 1) {
                        $origination = BTS::find($travelreq['origination']);
                        $destination = BTS::find($travelreq['destination']);
                        $result->description = '['.$origination->name.' to '.$destination->name.'] '.$result->description;
                        $result->save();
                    }
                    else if ($travelreq['travelsubtype'] == 2) {
                        $origination = MRT::find($travelreq['origination']);
                        $destination = MRT::find($travelreq['destination']);
                        $result->description = '['.$origination->name.' to '.$destination->name.'] '.$result->description;
                        $result->save();
                    }
                    else if ($travelreq['travelsubtype'] == 3) {
                        $origination = BRT::find($travelreq['origination']);
                        $destination = BRT::find($travelreq['destination']);
                        $result->description = '['.$origination->name.' to '.$destination->name.'] '.$result->description;
                        $result->save();
                    }
                    else if ($travelreq['travelsubtype'] == 4) {
                        $origination = AirportLink::find($travelreq['origination']);
                        $destination = AirportLink::find($travelreq['destination']);
                        $result->description = '['.$origination->name.' to '.$destination->name.'] '.$result->description;
                        $result->save();
                    }else {
                        $result->description = '['.$travelreq['origination'].' to '.$travelreq['destination'].'] '.$result->description;
                        $result->save();
                    }
                }

                $travel->save();
            }else if((int)$request->get('category')==2){
                $service = new Service();
                $service->item_id = $result->id;
                $servicereq = $request->get('service');
                $service->name = $servicereq['name'];
                $service->type = $servicereq['type'];
                $service->save();
            }else if((int)$request->get('category')==3){
                $medical = new Medical();
                $medical->item_id = $result->id;
                $medicalreq = $request->get('medical');
                $medical->symptom_name = $medicalreq['symptom_name'];
                $medical->hospital = $medicalreq['hospital'];
                $medical->save();
            }else if((int)$request->get('category')==4){
                $other = new Other();
                $other->item_id = $result->id;
                $otherreq = $request->get('other');
                $other->topic = $otherreq['topic'];
                $other->save();
            }
        }else{
            if((int)$request->get('category')==1){
                $travel = $result->travel;
                $travelreq = $request->get('travel');
                $travel->item_id = $result->id;
                $travel->travel_type = $travelreq['travel_type'];
                $travel->travel_sub_type = $travelreq['travel_sub_type'];
                $travel->destination = $travelreq['destination'];
                $travel->origination = $travelreq['origination'];
                $travel->save();
            }else if((int)$request->get('category')==2){
                $service = $result->service;
                $service->item_id = $result->id;
                $servicereq = $request->route('service');
                $service->name = $servicereq['name'];
                $service->type = $servicereq['type'];
                $service->save();
            }else if((int)$request->get('category')==3){
                $medical = $result->medical ;
                $medical->item_id = $result->id;
                $medical->item_id = $result->id;
                $medicalreq = $request->get('medical');
                $medical->symptom_name = $medicalreq['symptom_name'];
                $medical->hospital = $medicalreq['hospital'];
                $medical->save();
            }else if((int)$request->get('category')==4){
                $other = $result->other;
                $other->item_id = $result->id;
                $otherreq = $request->get('other');
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
        $updateModel->category = (int)$request->get('category');
        $updateModel->itemname = Auth::user()->user_name."-Item-".$updateModel->id;
        if($updateModel)
        {
            $this->after_save($request,$updateModel);
            $objectModel = $updateModel;
        }
        return $objectModel;
    }

}
