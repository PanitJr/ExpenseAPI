<?php

namespace App\Object\Users;

use App\apiResponse;
use Illuminate\Support\Facades\Auth;

class Login 
{
    protected $users;
    function __construct(Users $users = null)
    {
        $this->users = $users;
    }

    public function checkPermission($request)
    {
    	return true;
    }
    
    public function process($request)
    {
        $userFname =$request->input("Fname");
        $userLname =$request->input("Lname");
        // $Activestatus = UserStatus::where("userstatusname","=","active")->first();

        $users = Users::where('email', '=', $request->input("u"))->first();
        if($users){
//            if($auth->status_id!=$Activestatus->userstatusname){
//                $response = apiResponse::error("Inactive user"," Inactive user");
//            }
//            else{
            Auth::login($users,true);
            if(!$users->firstname){
                $users->firstname=$userFname;
                $users->lastname=$userLname;
                $users->save();
            }
            $response['token'] = Auth::user()->getRememberToken();
//            }
        }else {
            $response = apiResponse::error(400,"Email is not matched, please change the login email");
        }
        return $response;
    }

//        if(Auth::attempt([
//            "user_name"=>$request->input("u"),
//            "password"=>$request->input("p"),
//        ],true))
//        {
//            $response = ["token"=>Auth::user()->getRememberToken()];
//        }else {
//            throw new ApiException("LOGIN_FAIL","Login Fail");
//        }
//        return $response;
}
