<?php

namespace App\Http\Middleware;

use Closure;
use App\Object\Users\Users;
use App\apiResponse;
use Illuminate\Support\Facades\Auth;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->get('token');
        if(!empty($token))
        {
            $user = Users::where("remember_token",$token)->first();
            if($user)
            {
                 Auth::login($user);
                return $next($request);    
            }
            else{
                return apiResponse::error("INVALID_AUTH_TOKEN","token invalid or expired");
            }    
        }else{
            return apiResponse::error("TOKEN_EMPTY","Please send token");
        }
    }
}
