<?php

namespace App\Object\Item;

use App\Object\CC\CCDetail as Detail;
use App\Object\Item\TravelUtil\AirportLink;
use App\Object\Item\TravelUtil\BRT;
use App\Object\Item\TravelUtil\BTS;
use App\Object\Item\TravelUtil\MRT;
use Illuminate\Support\Facades\Auth;

class CCDetail extends Detail
{
    public function checkPermission($request)
    {
        $accesstion=false;
        //Auth::loginUsingId(9);
        $currentUser = Auth::user();
        $currentUser->role;
        $record = (int)$request->route('record');
        if ($currentUser->id == $record){
            $accesstion = true;
        }
        else if($currentUser->role->name == 'Admin' ){
            $accesstion = true;
        }
        else if($currentUser->role->name == 'Supervisor' ){
            foreach ($currentUser->child as $child){
                if ($child->id == $record) {
                    $accesstion = true;
                    break;
                }
            }
        }
        return $accesstion;
    }

    public function process($request)
    {   
        return parent::process($request);
    }
    public function convertData($objectModel)
    {
        $objectModel->entity;
        $objectModel->retriveStatus;
        $objectModel->retriveOpportunity;
        if($objectModel->category == 1){
            $objectModel->travel;
            $objectModel->travel->travelType;
            $objectModel->travel->travelSubType;
            if(!empty($objectModel->travel->travelSubType)) {
                if ($objectModel->travel->travelSubType->id == 1) {
                    $objectModel->travel->origination = BTS::find($objectModel->travel->origination);
                    $objectModel->travel->destination = BTS::find($objectModel->travel->destination);
                }
                if ($objectModel->travel->travelSubType->id == 2) {
                    $objectModel->travel->origination = MRT::find($objectModel->travel->origination);
                    $objectModel->travel->destination = MRT::find($objectModel->travel->destination);
                }
                if ($objectModel->travel->travelSubType->id == 3) {
                    $objectModel->travel->origination = BRT::find($objectModel->travel->origination);
                    $objectModel->travel->destination = BRT::find($objectModel->travel->destination);
                }
                if ($objectModel->travel->travelSubType->id == 4) {
                    $objectModel->travel->origination = AirportLink::find($objectModel->travel->origination);
                    $objectModel->travel->destination = AirportLink::find($objectModel->travel->destination);
                }
            }
        }
        if($objectModel->category == 2){
            $objectModel->service;
            $objectModel->service->serviceType;
        }
        if($objectModel->category == 3){$objectModel->medical;}
        if($objectModel->category == 4){$objectModel->other;}
        $objectModel->retriveCategory;
        $objectModel->date = date("d-m-Y",strtotime($objectModel->date));
        return $objectModel;
    }
}
