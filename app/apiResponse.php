<?php

namespace App;

class apiResponse extends \Response {

	public static function success($input = null) {
		$result['success'] = true;
		if ($input) {
			$result['data'] = $input;
		}
		return response()->json($result);
	}

	public static function error($code, $massage) {
		return response()->json([
			"success" => false,
			"error_code" => $code,
			"error_massage" => $massage
		],404);
	}
    public static function notfound() {
        return response()->json([
            'message' => 'Record not found'
        ], 404);
    }
}