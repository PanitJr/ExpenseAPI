<?php

namespace App\Object\Users;

use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCDetail as Detail;

class CCDetail extends Detail
{
    public function convertLayout($objectModel)
    {
        $layout = [];
        $Object = $objectModel->getObject();
        $Blocks = $Object->getBlock()->orderby('sequence')->get();
        foreach ($Blocks as $Block) {
            $Fields = $Block->getField()->whereNotIn('fieldname',[
                'password',
                'confirm_password',
                ])->orderby('sequence')->get();
            $Block->fields = $Fields;
        }
        return $Blocks;
    }

}
