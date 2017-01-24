<?php

namespace App\Object\Users;

use App\Object\CC\Entity;
use App\Object\Profiles\Profiles;
use App\Object\Role\Role;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class Users extends Entity implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

	public $table = 'users';
   	
    public $timestamps = false;

    public $object_name = "Users";

    public $columns_list = [
    	'Username'=>'user_name',
    	'Email'=>'email',
        'First Name'=>'firstname',
        'Last Name'=>'lastname',
    ];

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token','confirm_password'
    ];

    public function getLabel()
    {
        return sprintf("%s %s",$this->firstname,$this->lastname);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profiles::class, 'user_profile', 'profile_id', 'user_id');
    }

    public function role()
    {
        return $this->hasOne(Role::class,'id','role_id');
    }
}


