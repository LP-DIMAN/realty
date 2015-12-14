<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Adverts;



class RealtorController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		$this->middleware('auth');
		
		
	}
	public function index()
	{
		$user = User::Can('REALTOR');

		if($user == null){
			return redirect('/home');
		}
		$data['clients'] = User::get_clients();
		$data['adverts'] = Adverts::get_adverts_realtor(Auth::user()->id);
		return view('realtor',$data);
	}

	

}
