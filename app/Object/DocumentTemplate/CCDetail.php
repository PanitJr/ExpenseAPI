<?php

namespace App\Object\DocumentTemplate;

use App\Object\Users\Users as User;
use App\CC\Loader;
use App\CC\Error\ApiException;
use App\Object\CC\CCEdit as Detail;

class CCDetail extends Detail
{   
    public function convertData($objectModel)
    {
    	$objectModel->entity;
    	$objectModel->entity->createUser =  User::getLabel($objectModel->entity->createid);
    	$objectModel->entity->ownerUser =  User::getLabel($objectModel->entity->ownerid);
    	$objectModel->entity->modifiedUser =  User::getLabel($objectModel->entity->modifiedby);
 
        return $objectModel;
    }
}