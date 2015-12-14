<?php 
namespace App\Http\Controllers;
use App\Adverts;
use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClientController extends Controller {



	public function __construct()
	{
		$this->middleware('auth');
		
		
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = User::Can('CLIENT');

		if($user == null){
			return redirect('/home');
		}
		$client = Auth::user()->id;
		$data['remember_adverts_client'] = Adverts::get_remember_adverts_client($client);
		return view('client',$data);
	}


		public function id_advert(Request $request)
	{
		$id_advert = $request->input('comment');

		return $id_advert;
		//Adverts::add_comment($comment,$id_client,$id_advert);
	

		
	}



	public function edit_advert(Request $request)
	{
		$id_advert = $request->input('id_advert');
		$id_client = Auth::user()->id;
		$comment = $request->input('params');

		Adverts::add_comment($comment,$id_client,$id_advert);
		

		
	}

	public function delete_advert(Request $request)
	{
		$id_advert = $request->input('comment');
		$id_client = Auth::user()->id;
		Adverts::delete_advert($id_client,$id_advert);

		
	}
	public function cross_advert(Request $request)
	{
		$id_advert = $request->input('id_advert');
		$id_client = Auth::user()->id;
		Adverts::cross_advert($id_client,$id_advert);

		
	}
	public function lead_advert(Request $request)
	{
		$id_advert = $request->input('id_advert');
		$id_client = Auth::user()->id;
		Adverts::lead_advert($id_client,$id_advert);

		
	}

}
