<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 4/1/2017
 * Time: 8:59 PM
 */

namespace App\Object\Expense;

use Illuminate\Support\Facades\Auth;
use Storage;
use Response;
use Illuminate\Http\Request;

class ExpensePdf
{
    public function checkPermission($request)
    {
        $accession=false;
        //Auth::loginUsingId(9);
        if (Auth::user()->role->name == 'Admin'){
            $accession = true;
        }
        return $accession;
    }
    public function process(Request $request)
    {
        putenv('LC_ALL=en_US.UTF-8');
        putenv('LANGUAGE=en:el');
        $mapping = $request->getContent();

        $ExpensePDFGen = app_path('Service/ExpensePDFGen.jar');

        $id = md5(microtime(true));

        $docxPath = storage_path("app/ExcelTemplate/expense.xlsx");
        $jsonFile  = "JsonTemplate/".$id.".json";
        $resultPath = storage_path("app/PDFResult/Expense/".$id.".pdf");

        Storage::put($jsonFile , $mapping);
        $jsonPath =  storage_path("app/" .$jsonFile);
        $result = exec("java -jar $ExpensePDFGen $docxPath $resultPath $jsonPath");

        Storage::delete($jsonFile);
        if($result == "Success")
        {
            return array(
                "success" => true,
                "url" => url("Expense/PDF/". $id .".pdf")
            );
        }
        else
        {
            var_dump($result);
            list($error,$error_message)=explode("||",$result);
            return array(
                "success"=>false,
                "error"=>$error,
                "error_message"=>$error_message
            );
        }

    }
}