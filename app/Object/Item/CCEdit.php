<?php

namespace App\Object\Item;

use App\CC\Error\ApiException;
use App\CC\Loader;
use App\Object\CC\CCEdit as Edit;
use App\Object\Item\ServiceUtil\ServiceType;
use App\Object\Opportunity\Opportunity;
use App\Object\Item\ItemUtil\ItemCategory;
use App\Object\Item\TravelUtil\TravelSubType;
use App\Object\Item\TravelUtil\TravelType;
use Illuminate\Support\Facades\Auth;

class CCEdit extends Edit
{
    public function checkPermission($request)
    {
        $record = (int)$request->route('record');
        $objectClass =  Loader::getObject('Item');
        $objectModel = $objectClass::find($record);

        $error_code = "ACCESS_DENIED";

        $accession=false;
        //Auth::loginUsingId(9);
        $record = (int)$request->route('record');

        foreach (Auth::user()->profiles as $profile){
            foreach ($profile->getPermission as $permission){
                if(empty($record)){
                    if($permission->name == 'create' && $permission->objectid == '8'){
                        $accession = true;
                        break;
                    }
                }
                else if(!empty($record)){
                    if($permission->name == 'edit' && $permission->objectid == '8'){
                        $accession = true;
                        break;
                    }
                }
            }
        }
        if(!$objectModel && !empty($record))
        {
            throw new ApiException($error_code, 'Record not found ! ');
        }

        if($objectModel && $objectModel->entity->deleted ==1)
        {
            throw new ApiException($error_code, 'The record you are trying to view has been deleted.');
        }
        return $accession;
    }

    public function process($request)
    {
        $error_code = "ACCESS_DENIED";
        $record = (int)$request->route('record');

        $objectClass = 	Loader::getObject('Item');
        if(empty($record))
        {
            $objectModel = new $objectClass();
        }
        else
        {
            $objectModel = $objectClass::find($record);
            $objectModel->entity;
            if($objectModel['entity']['ownerid'] != Auth::user()->id){
                throw new ApiException($error_code, 'This is not your item');
            }
        }


        $label = $objectModel->getLabel();
        $layout = $this->convertLayout($objectModel);
        $data = $this->convertData($objectModel);

        return [
            "objectname"=>'Item',
            "record"=>$record,
            "label"=>$label,
            "blocks"=>$layout,
            "data"=>$data
        ];
    }
    public function convertLayout($objectModel)
    {

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
                if($Field->fieldname == "category")
                {
                    $Field->category = ItemCategory::all();
                    $Field->traveltype = TravelType::all();
                    $Field->travelsubtype = TravelSubType::all();
                }
                if($Field->fieldname == "opportunity"){
                    $Field->opportunity = Opportunity::where('active', 1)->get();
                }
            }
            $Fields['traveltype'] = TravelType::all();
            $Fields['travelsubtype'] = TravelSubType::all();
            $Fields['servicetype'] = ServiceType::all();
            $Block->fields = $Fields;
        }
        return $Blocks;
    }
    public function convertData($objectModel)
    {
        if(!empty($objectModel->id)) {
        $objectModel->Category;
        $objectModel->Opportunity;
        if($objectModel->Category['name'] == "Travel"){
            $objectModel->Travel;
            $objectModel->Travel->type;
            $objectModel->Travel->subtype;
        }
        else if($objectModel->Category['name'] == "Service"){
            $objectModel->Service;
            $objectModel->Service->type;
        }
        else if($objectModel->Category['name'] == "Other"){$objectModel->Other;}
        else if($objectModel->Category['name'] == "Medical"){$objectModel->Medical;}
        $objectModel->date = date("d-m-Y",strtotime($objectModel->date));
        }
        return $objectModel;
    }

}