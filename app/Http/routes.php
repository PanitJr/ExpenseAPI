<?php

use App\apiResponse;
use App\Object\Item\TravelUtil\AirportLink;
use App\Object\Item\TravelUtil\BRT;
use App\Object\Item\TravelUtil\BTS;
use App\Object\Item\TravelUtil\MRT;
use Illuminate\Http\Request;
use App\Http\Controllers\Object\ObjectController;

if (! function_exists('objectRun')) {
	
	/**
	 * objectRun For create dynamic controller for route
	 * @param  String $ProcessFile 	[custome object file process name]
	 * @return Function             [function for route]
	 */
	function objectRun($ProcessFile,$mainObjectName = null) {
		return function(Request $Request,$objectName = null) use ($ProcessFile,$mainObjectName) {	
			$objectName = !$mainObjectName?$objectName:$mainObjectName;
			return ObjectController::getResult($Request,$objectName,$ProcessFile);
		};
	}
}

Route::get('/', function () {
	return view('welcome');
});

Route::get('Expense/PDF/{filename}', 'ExpensePDFController@Download');

Route::get('AllExpense/PDF/{filename}', 'AllExpensePDFController@Download');

Route::get('test', 'testController@test');


Route::get('Doc/file/{record}/{filename}', 'FileController@DownloadFile');


Route::group(['prefix' => 'img'],function(){
	Route::get('{objectName}/{id}/{field}/{image_name}','ImageController@create');	
});

Route::group(['prefix' => 'api' ,"middleware" =>['cors','GZip']], function () {
    //Route::match(['post','options'],'logingoogle', 'User\loginController@loginGoogle');
    Route::match(['post','options'],'logingoogle', objectRun('Login','Users'));
	//Route::match(['post','options'],'login', objectRun('Login','Users'));


	Route::group(['middleware'=>"App\Http\Middleware\VerifyApiToken"],function(){		

		Route::match(['post','options'],'test_post', function(Request $Request){
			return $Request->all();
		});

		Route::match(['post','options'],'current_user', objectRun('Current','Users'));

		Route::get('object_home','Object\ObjectController@object_home');	

		Route::get('{objectName}/list',objectRun('CCList'));	

		Route::get('{objectName}/detail/{record}', objectRun('CCDetail'));

		Route::get('{objectName}/edit/{record?}', objectRun('CCEdit'));

		Route::match(['post','options'],'{objectName}/edit/{record?}', objectRun('CCSave'));

		Route::match(['post','options'],'{objectName}/delete/{record}', objectRun('CCDelete'));

		Route::match(['post','options'],'Expense/reject/{record}', objectRun('RejectExpense','Expense'));
        Route::match(['post','options'],'Expense/Approve/{record}', objectRun('ApproveExpense','Expense'));
        Route::match(['post','options'],'Expense/paid/{record}', objectRun('PaidExpense','Expense'));

        Route::match(['post','options'],'{objectName}/ExpensePdf/{record}', objectRun('ExpensePdf','Expense'));
        Route::match(['post','options'],'{objectName}/AllExpensePdf', objectRun('AllExpensePdf','Expense'));

        Route::get('Expense/AllExpense', objectRun('AllExpense','Expense'));

        Route::get('Item/reject/{record}', objectRun('RejectItem','Item'));

		Route::group(['prefix' => 'TravelUtil'], function () {
            Route::group(['prefix' => '1'], function () {
                Route::get('/', function () {
                    return BTS::getBts();
                });
                Route::get('/cost/{ori}/{desti}', function ($ori = 'ori', $desti = 'desti') {
                    return BTS::getCost($ori, $desti);
                });
            });
            Route::group(['prefix' => '2'], function () {
                Route::get('/', function () {
                    return MRT::getMrt();
                });
                Route::get('/cost/{ori}/{desti}', function ($ori = 'ori', $desti = 'desti') {
                    return MRT::getCost($ori, $desti);
                });
            });
            Route::group(['prefix' => '3'], function () {
                Route::get('/', function () {
                    return BRT::getBrt();
                });
                Route::get('/cost/{ori}/{desti}', function ($ori = 'ori', $desti = 'desti') {
                    return BRT::getCost($ori, $desti);
                });
            });
            Route::group(['prefix' => '4'], function () {
                Route::get('/', function () {
                    return AirportLink::getAirportLink();
                });
                Route::get('/cost/{ori}/{desti}', function ($ori = 'ori', $desti = 'desti') {
                    return AirportLink::getCost($ori, $desti);
                });
            });
            });

		



		/**
		 * Setting API
		 * api for admin setup system 
		 */
		Route::group(['prefix' => 'Settings'], function () {

			/**
			 * Layout setting
			 */
			Route::group(['prefix' => 'Layout'], function () {
				Route::get('objectAll', 'Object\Settings\LayoutController@objectAll');	
				Route::get('object/{objectName}', 'Object\Settings\LayoutController@object');	
			});
		});
			

	});



});