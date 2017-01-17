<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CC\Loader;
use App\Http\Requests;
use App\Salesforce\SF;
use App\Salesforce\sfdctoolkit\SFDCConnector;
use App\Salesforce\sfdctoolkit\soapclient\SObject;
use App\Sync\Salesforce\Brand;

use App\Sync\ERP\model\ZCmdComm;
use App\Sync\ERP\model\EXPORTDO;
use App\Sync\ERP\model\EXPORTINV;

class salesforceController extends Controller
{
 	public function index(Request $Request)
 	{
 		// $StandardPricebook = SF::selectQuery("SELECT Id from Product2 limit 2");
		// dd($StandardPricebook);
 	// 	array(
		//   "id"=>"a0dp0000001qsSRAAY"
		//   "Branch__c"=> "CDC"
		//   "Warehouse__c"=> "CDC"
		//   "Product__c"=> "70"
		//   "Lot__c"=> "test_stock"
		//   "Date__c"=> "2016-07-23"
		//   "Average_Cost__c"=> "20.00"
		//   "ERP_Quantity__c"=> "30"
		//   "Remaining_Quantity__c"=> "40"
		//   "DO_Quantity__c"=> "50"
		// );

		// $SF = SFDCConnector::getConnection();
		// $sObject = new SObject();
		// $sObject->type = 'Stock__c';
		// $sObject->fields = array(
		//   "CCKeyId__c"=>1,
		//   "Branch__c"=> "CDC",
		//   "Warehouse__c"=> "CDC",
		//   "Product__r.CCKeyId__c"=> "tenproductupsert",
		//   "Lot__c"=> "test_stock",
		//   "Date__c"=> "2016-07-23",
		//   "Average_Cost__c"=> "2030.00",
		//   "ERP_Quantity__c"=> "30",
		//   "Remaining_Quantity__c"=> "40",
		//   "DO_Quantity__c"=> "50",
		// );

		// $data = $SF->upsert("CCKeyId__c",array($sObject));
		// dd($data);

 	// 	$Opportunity = SF::selectQuery("SELECT Id,Name from Opportunity where Name = 'Test 15 July 2016'");
	

		// $Account = SF::selectQuery("SELECT Id,Name from Account where Name = 'company deemak'");
		
		// dd($Opportunity[0]->Id,$Account[0]->Id);

 		// $sf = SFDCConnector::getConnection();

 		// $sql = "UPDATE Product2 SET No_of_Est_Delivery_Date__c = 20 WHERE Family = 'Christopher Guy'";

 		// $result =$sf->query($sql);
 		// dd($result);
		
		// $StandardPricebook = SF::selectQuery("SELECT Id from Product2 where Family = 'Standard Price Book'");
		// Brand::updateDeliveryDate('Christopher Guy',40);
			
 	// 	$dataPricebookEntry = array(
  // 			"UnitPrice"=>"20000",
  // 			"IsActive"=>"true",
  // 			// "StandardPrice"=>"20000",
  // 			// "UseStandardPrice"=>true,
  // 			"Product2Id"=> "01tp0000001ll65AAA",
  // 			"Pricebook2Id"=> "01s90000000LUCJAA4"
		// );

 		// $PricebookEntry = new SF("PricebookEntry",$dataPricebookEntry);	
 		// $id = $PricebookEntry->insert();
 		// var_dump($id);


 	// 	$dataPricebookEntry = array(
  // 			"id"=>"01up0000000iMUaAAM",
  // 			"UnitPrice"=>"24000",
  // 			// "Product2Id"=> "01tp0000001ll65AAA",
  // 			// "Pricebook2Id"=> "01sp00000004RyaAAE"
		// );

 	// 	$PricebookEntry = new SF("PricebookEntry",$dataPricebookEntry);	
 	// 	$id = $PricebookEntry->update();
 	// 	var_dump($id);


 	// 	$sfdc = new SFDCConnector ();
		// $connect = $sfdc->getConnection ();
	 //    $sObject = new SObject();
	 //    $sObject->fields = array(
		// 	'Id'=>"01tp0000001lQuUAAU",
		// 	'Finishing__c'=>"",
		// );
	 //    $sObject->type = 'Product2';


	 //    $sObject->fields = array(
		// 	'id'=>"01up0000000i52lAAA",
		// 	'UnitPrice'=>"55000",
		// );
	 //    $sObject->type = 'PricebookEntry';

  //   	try {
	    
	 //    	$CreateResponse = $connect->update(array ($sObject));
	 //    	echo "<pre>";
	 //    	print_r($CreateResponse[0]->id);
	 //    	echo "</pre>";
	 //    } catch (Exception $e) {
		//     echo "<BR>Error Creating the Case! ";
		//     echo $e->faultstring;
		// 	exit;
	 //    }

 	// 	 \Auth::loginUsingId(1);

 	// 	$Model = Loader::getObject('RealProduct');
		// $object =$Model::find(76);
		// $mapping = array(
		// 	"id"=>"product2_sfid",			
		// 	"Description"=>"descript",
		// 	"Name"=>"productname",
		// 	"Article_Number__c"=>"article_number",
		// 	"Category__c"=>"category",
		// 	"CC_External_ID__c"=>"article_number",
		// 	"Covering__c"=>"covering",
		// 	"Customer_Connect_ID__c"=>"id",
		// 	"Dimension__c"=>"dimension",
		// 	"Finishing__c"=>"finishing",
		// 	"Full_Customer_connect_ID__c"=>"id",
		// 	"Remark__c"=>"remark",
		// );

		// $data = array();
		// foreach ($mapping as $keySF => $keyCC) {
		// 	if(isset($object->{$keyCC}))
		// 	{
		// 		$data[$keySF] = $object->{$keyCC};
		// 	}
		// }
		// $Salesforce = new SF("Product2",$data);
		// if(!isset($data['id']))
		// {
		// 	$id = $Salesforce->insert();
		// 	$object->{$mapping['id']} = $id;
		// 	$object->save();	
		// }
		// else
		// {
		// 	$Salesforce->update();
		// }

		// echo "<pre>";
		// print_r($object);
		// echo "</pre>";
		
		// exit;		
	

		// $query = "SELECT Article_Number__c from Product2 where Id = '01tp0000001lQuUAAU'";
		// echo "<pre>";
		// print_r(get_class_methods($connect));
		// echo "</pre>";
		// exit;
		// $response = $connect->query($query);
		// // // QueryResult object is only for PARTNER client
		// $queryResult = new QueryResult($response);
		// var_dump($queryResult->records)	;
		// foreach ($queryResult->records as $record) {
		//   echo "Id = ".$record->Id;
		//   echo "First Name = ".$record->FirstName;
		//   echo "Last Name = ".$record->LastName;
		// }

		// $Pricebook2 = SF::selectQuery("SELECT Id,Name,Description from Pricebook2 where Name = 'Euro Creations'");
		// $Pricebook2[0]->Id
		// for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {
		
		// $queryResult->rewind();
     	// var_dump($queryResult->current()->Description);
		
		// }
		// var_dump();
		

		// echo "<pre>";
		// // print_r(get_class_methods($result));
		// print_r($result);
		// echo "</pre>";
 	}  
}

