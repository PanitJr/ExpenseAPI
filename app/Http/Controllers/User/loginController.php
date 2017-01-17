<?php

namespace App\Http\Controllers\User;
use Illuminate\Foundation\Auth\User;
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

    public function loginGoogle(Request $request)
    {
        $userFname =$request->input("Fname");
        $userLname =$request->input("Lname");
        // $Activestatus = UserStatus::where("userstatusname","=","active")->first();

        $auth = User::where('email', '=', $request->input("u"))->first();
        if($auth){
//            if($auth->status_id!=$Activestatus->userstatusname){
//                $response = apiResponse::error("Inactive user"," Inactive user");
//            }
//            else{
            Auth::login($auth,true);
            if(!$auth->firstname){
                $auth->firstname=$userFname;
                $auth->lastname=$userLname;
                $auth->save();
            }
            $response = apiResponse::success([
                "token"=>Auth::user()->getRememberToken()
            ]);
//            }
        }else {
            $response = apiResponse::error(400,"Email is not matched, please change the login email");
        }
        return $response;
    }

}
