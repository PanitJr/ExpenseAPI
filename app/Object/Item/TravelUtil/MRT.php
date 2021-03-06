<?php

/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/29/2017
 * Time: 12:13 AM
 */
namespace App\Object\Item\TravelUtil;


use App\apiResponse;
use App\CC\Error\ApiException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MRT extends Model
{
    public $table = 'mrt';
    public static function getMrt()
    {
        try {
            $mrt = DB::table('mrt')->get();
            return apiResponse::success($mrt);
        }
        catch(ApiException $e){
            return apiResponse::error($e->error_code,$e->error);
        }
    }
    public static function getCost($ori,$des)
    {
        $cost = DB::table('mrt_cost_station')
            ->select('cost')
            ->where('origination',$ori)
            ->where('destination',$des)
            ->get();
        try {
            return apiResponse::success($cost);
        }catch(ApiException $e){
            return apiResponse::error($e->error_code,$e->error);
        }
    }
}