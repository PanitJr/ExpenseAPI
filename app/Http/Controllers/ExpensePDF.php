<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 3/19/2017
 * Time: 2:32 PM
 */

namespace app\Http\Controllers;

use Illuminate\Support\Facades\File;
use Storage;
use Response;
use Illuminate\Http\Request;

class ExpensePDF extends Controller
{
    public function Process(Request $request)
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
    public function Download($filename)
    {
        $fileExcel = sprintf("app/PDFResult/Expense/%s",$filename);
        $path = storage_path($fileExcel);
        //        return Response::download($path, $filename);
        if (File::isFile($path))
        {
            $file = File::get($path);
            $response = Response::make($file, 200);
            // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
            $response->header('Content-Type', 'application/pdf');

            return $response;
        }
    }
}
/*$content_types = [
    'application/octet-stream', // txt etc
    'application/msword', // doc
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
    'application/vnd.ms-excel', // xls
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
    'application/pdf', // pdf
];*/