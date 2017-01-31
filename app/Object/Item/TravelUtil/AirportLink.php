<?php

/**
 * Created by PhpStorm.
 * User: panit
 * Date: 1/29/2017
 * Time: 12:14 AM
 */
namespace App\Object\Item\TravelUtil;
use App\apiResponse;
use App\CC\Error\ApiException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AirportLink extends Model
{
    public static function getBts()
    {
        try {
            $bts = DB::table('airportlink')->get();
            return apiResponse::success($bts);
        }
        catch(ApiException $e){
            return apiResponse::error($e->error_code,$e->error);
        }
    }
    public static function getCost($ori,$des)
    {
        $cost = DB::table('airportlink_cost_station')
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