<?php

namespace App\CC;

class Field extends FieldBasic
{
    public function fieldtype()
    {
    	return $this->hasOne(FieldTypeBasic::class, 'id', 'type');
    }

    public function get_fieldType()
    {
    	return $this->fieldtype?$this->fieldtype->fieldtype:null;
    }
}
