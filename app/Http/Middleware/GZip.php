<?php namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Response;

class GZip {

	 /**
	  * Handle an incoming request.
	  *
	  * @param \Illuminate\Http\Request $request
	  * @param \Closure $next
	  * @return mixed
	  */
	public function handle($request, Closure $next)
	{ 
		ob_start('ob_gzhandler');
		return $next($request);	 
	} 
}
