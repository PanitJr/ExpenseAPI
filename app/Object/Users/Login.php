<?php

namespace App\Object\Users;

use Auth;
use App\CC\Error\ApiException;

class Login 
{
	public function checkPermission($request)
    {
    	return true;
    }
    
    public function process($request)
    {
        if(Auth::attempt([
            "user_name"=>$request->input("u"),  
            "password"=>$request->input("p"),   
        ],true))
        {
            $response = ["token"=>Auth::user()->getRememberToken()];
        }else {
            throw new ApiException("LOGIN_FAIL","Login Fail");
        }
        return $response;

    	
    }
}
