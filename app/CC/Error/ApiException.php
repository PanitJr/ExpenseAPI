<?php 

namespace App\CC\Error;

use Exception;

class ApiException extends Exception
{
	public function __construct($code, $message) {
        $this->error = $message;
        $this->error_code = $code;
    }
}