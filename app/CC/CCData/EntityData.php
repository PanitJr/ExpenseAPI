<?php

namespace App\CC\CCData;

use Illuminate\Database\Eloquent\Model;
use App\CC\CCTrait\DefaultEntity;

class EntityData extends Model
{
	use DefaultEntity;

    public $timestamps = true;

    protected $table = 'entitys';
}
