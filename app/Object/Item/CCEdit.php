<?php

namespace App\Object\Item;

use App\Object\CC\CCEdit as Edit;
use App\Object\Item\ServiceUtil\ServiceType;
use App\Object\Opportunity\Opportunity;
use App\Object\Item\ItemUtil\ItemCategory;
use App\Object\Item\TravelUtil\TravelSubType;
use App\Object\Item\TravelUtil\TravelType;

class CCEdit extends Edit
{
    public function checkPermission($request)
    {
        return true;
    }

    public function process($request)
    {
    	return parent::process($request);
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
        if($objectModel->Category['name'] == "Travel"){$objectModel->Travel;}
        else if($objectModel->Category['name'] == "Service"){$objectModel->Service;}
        else if($objectModel->Category['name'] == "Other"){$objectModel->Other;}
        else if($objectModel->Category['name'] == "Medical"){$objectModel->Medical;}
        $objectModel->Entity;
        $objectModel->date = date("d-m-Y",strtotime($objectModel->date));
        }
        return $objectModel;
    }

}