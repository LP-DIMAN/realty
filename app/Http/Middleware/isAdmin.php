<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class isAdmin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$id = Auth::user()->id;
		$admin = DB::select("select id_role from users where id=$id");
		$arr[]= array();
		foreach ($admin as $administrator) {
			$arr = $administrator;

		}
		if ($arr->id_role!==1){
			return redirect('/home');
		}
		return $next($request);
	}

}
