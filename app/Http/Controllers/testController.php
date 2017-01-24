<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CC\Loader;
use App\Http\Requests;
use App\Object\Profile\Profile;
use App\Object\Profile\ObjectModel;

use Gelf\Transport\UdpTransport;
use Gelf\Transport\HttpTransport;
use Gelf\Publisher;
use Gelf\Message;
use Gelf\Logger;
use App\Object\Users\Users;

use App\dynamic;
use App\childdynamic;

class testController extends Controller
{
 	public function log(Request $Request)
 	{
		$transport = new UdpTransport("103.208.25.54", 9005, UdpTransport::CHUNK_SIZE_LAN);

		$publisher = new Publisher();
		$publisher->addTransport($transport);
		
		if($Request->get('text',false))
		{
			$logger = new Logger($publisher, "example-facility");
		
			$logger->alert($Request->get('text'));	
			echo "success log : ".$Request->get('text');	
		}
		else
		{
			echo "use <a href='http://ccapi.demosolution.com:8080/test_log?text=textfortest'>http://ccapi.demosolution.com:8080/test_log?text=textfortest</a>";
		}
		

 	}  

 	public function test(Request $request)
 	{
 		// $profile = Profiles::find(1);
 		
 		// dd($profile->objects[0]->hasPermission()[0]->permission);
 		// $User = Users::find(1);
 		// dd($User->profiles);
 		// $user = new dynamic;
 		// $user->setTable('users');
 		dd(childdynamic::getTest());

 	}
}

