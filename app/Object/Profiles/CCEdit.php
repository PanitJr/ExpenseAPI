<?php

namespace App\Object\Profiles;

use App\CC\Loader;
use App\Object\CC\CCEdit as Edit;
use App\CC\Error\ApiException;

class CCEdit extends Edit
{
    public function convertLayout($objectModel)
    {
        $Object = $objectModel->getObject();
        $Blocks = $Object->getBlock()->orderby('sequence')->get();
        foreach ($Blocks as $Block) {
            if($Block->blocklabel == 'Profiles Permission'){
                $Fields = ObjectModel::hasPermission($Object->id);
                $Block->fields = $Fields;
            }else {
                $Fields = $Block->getField()->orderby('sequence')->get();
                $Block->fields = $Fields;
            }
        }
        return $Blocks;
    }

    public function convertData($objectModel)
    {
        $objectModel->getPermission;
        foreach ($objectModel->getPermission as $per){
            $per->object;
        }
        return $objectModel;
    }
}