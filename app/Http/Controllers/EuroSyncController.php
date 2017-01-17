<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Artisan;
use DB;
use App\CC\Loader;
use App\Sync\ERP\model\IMPORTPROD;
use App\Sync\ERP\model\IMPORTCUST;
use App\Sync\ERP\model\IMPORTSO;
use App\Sync\ERP\model\ZCmdComm;
use App\Http\Requests;

class EuroSyncController extends Controller
{
 	public function index(Request $Request)
 	{
 		$DB = DB::connection('sqlsrv');
 		$select = $DB->table('INFORMATION_SCHEMA.TABLES')
               ->select('TABLE_NAME')
               ->get();
       	
       	echo "<h4>Table</h4>";
        echo "<pre>";
 		foreach ($select as $key => $value) {
        	var_dump($value->TABLE_NAME);
        }
 		echo "</pre>";

 		echo "<br>";
 		echo "<hr>";
 		echo "<h4>Field On Table</h4>";
 		
 		foreach ($select as $value) {
 			$select2 = $DB->table('INFORMATION_SCHEMA.COLUMNS')
               ->select('COLUMN_NAME')
               ->where('TABLE_NAME',$value->TABLE_NAME)
               ->get();

            echo "<hr>";
 			echo "<h5>{$value->TABLE_NAME}</h5>";   

 			echo "<pre>";
	 		foreach ($select2 as  $value2) {
	        	var_dump($value2->COLUMN_NAME);
	        }
	 		echo "</pre>";
 			echo "<br>";
 		}
 	} 

  public function test_data(Request $Request)
  {
    // $model\ZCmdComm = ZCmdComm::getZCmdComm("IMPORTPROD",20);  
    

    $model1 = IMPORTPROD::orderBy('FTCREATE','desc')->first();  
  
    $data1 = ZCmdComm::where('FCDATAID',$model1->FCDATAID)->first();
    
    $model2 = IMPORTCUST::orderBy('FTCREATE','desc')->first();  
    $data2 = ZCmdComm::where('FCDATAID',$model2->FCDATAID)->first();

    $model3 = IMPORTSO::orderBy('FTCREATE','desc')->first();  
    $data3 = ZCmdComm::where('FCDATAID',$model3->FCDATAID)->first();

    dd($data1,$model1,$data2,$model2,$data3,$model3);
    // $data = ZCmdComm::where('FNLINKSTAT','!=',0)->get();    
    // dd($data);
  } 

  public function so(Request $Request)
  {
    $model3 = IMPORTSO::orderBy('FTCREATE','desc')->first();  
    $data3 = ZCmdComm::where('FCDATAID',$model3->FCDATAID)->first();

    dd($data3,$model3);

  } 


  public function euro_to_sf(Request $Request)
  { 
    echo "<pre>";
    Artisan::call('erp:sync_import_erp');
    echo "</pre>";
  }
}

