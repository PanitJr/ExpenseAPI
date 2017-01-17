<?php namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Response;

class CORS {

	 /**
	  * Handle an incoming request.
	  *
	  * @param \Illuminate\Http\Request $request
	  * @param \Closure $next
	  * @return mixed
	  */
	public function handle($request, Closure $next)
	{ 
		$content = $next($request);
		if(method_exists($content, "header"))
		{
			return $content
				->header('Access-Control-Allow-Origin' , '*')
				->header('Access-Control-Max-Age', '0')	
 				->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
				->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin,Process-Data, Authorization, X-Requested-With');
		}
	 
		return $content;
	} 
}
