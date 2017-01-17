<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use Response;
use Artisan;
use DB;
use App\CC\Loader;
use App\Http\Requests;

class FileController extends Controller
{
 	public function DownloadFile($record,$filename = 'generate.docx')
    {
        $fileDocx = sprintf("app/docx/%s/%s.docx",$record,$record);
        $path = storage_path($fileDocx);
        return Response::download($path, $filename);
    }
}

