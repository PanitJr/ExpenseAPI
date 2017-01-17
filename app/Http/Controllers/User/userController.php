<?php

namespace App\Http\Controllers\User;

use Auth;
use App\apiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class userController extends Controller
{
    public function current()
    {
    	return apiResponse::success([
    		"user"=>Auth::user()
    	]);
    }
}
