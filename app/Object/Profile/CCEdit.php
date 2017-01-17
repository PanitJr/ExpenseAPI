<?php

namespace App\Object\Profile;

use App\CC\Loader;
use App\Object\CC\CCEdit as Edit;
use App\CC\Error\ApiException;

class CCEdit extends Edit
{
    public function process($request)
    {
        $objectLayout = ObjectModel::getModuleLayout();
        $result = parent::process($request);
        $result["modules"] = $objectLayout;
            
        return $result;
    }
    public function convertLayout($objectModel)
    {
        $Object = $objectModel->getObject();
        $Blocks = $Object->getBlock()->orderby('sequence')->get();
        foreach ($Blocks as $Block) {
            if($Block->blocklabel == 'Profile Permission'){
                $Fields = ObjectModel::hasPermission($Object->id);
                $Block->fields = $Fields;
            }else {
                $Fields = $Block->getField()->orderby('sequence')->get();
                $Block->fields = $Fields;
            }
        }
        return $Blocks;
    }
}