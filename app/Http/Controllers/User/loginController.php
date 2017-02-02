<?php

namespace App\Http\Controllers\User;
use App\Object\Users\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\apiResponse;

class loginController extends userController
{


    public function login(Request $request)
    {
        if(Auth::attempt([
            "email"=>$request->input("u"),
            "password"=>$request->input("p"),
        ],true))
        {
            $response = apiResponse::success([
                "token"=>Auth::user()->getRememberToken()
            ]);
        }else {
            $response = apiResponse::error("LOGIN_FAIL","Login Fail");
        }
        return $response;
    }


}
