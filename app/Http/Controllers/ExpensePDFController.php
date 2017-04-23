<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 3/19/2017
 * Time: 2:32 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Storage;
use Response;
use Illuminate\Http\Request;

class ExpensePDFController extends Controller
{
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