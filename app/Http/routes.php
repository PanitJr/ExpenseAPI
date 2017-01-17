<?php

use App\apiResponse;
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

Route::get('test', 'testController@test');


Route::get('Doc/file/{record}/{filename}', 'FileController@DownloadFile');


Route::group(['prefix' => 'img'],function(){
	Route::get('{objectName}/{id}/{field}/{image_name}','ImageController@create');	
});

Route::group(['prefix' => 'api' ,"middleware" =>['cors','GZip']], function () {
    Route::match(['post','options'],'logingoogle', 'User\loginController@loginGoogle');
	Route::match(['post','options'],'login', objectRun('Login','Users'));


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

		Route::group(['prefix' => 'Users'], function () {

			Route::get('list',objectRun('CCList','Users'));	
			Route::get('detail/{record}',objectRun('CCDetail','Users'));	
			Route::match(['post','options'],'change_password', objectRun('ChangePassword','Users'));	
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