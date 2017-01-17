<?php

namespace App\CC;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $table = 'customview';

    public $timestamps = false;

    public function getId()
    {
    	return $this->id;
    }
}
