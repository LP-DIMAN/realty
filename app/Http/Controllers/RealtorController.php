<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\User;



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

		if($user==null){
			return redirect('/home');
		}
	
		return view('realtor');
	}

	

}
