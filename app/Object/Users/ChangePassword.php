<?php

namespace App\Object\Users;

use Hash;
use Auth;
use App\CC\Error\ApiException;

class ChangePassword 
{
    public function checkPermission($request)
    {
        return true;
    }

    public function process($request)
    {   
        $password = $request->get('password');
        $user = Auth::user();
        $user->password = Hash::make($password);
        $user->save();
        return true;
    }

}