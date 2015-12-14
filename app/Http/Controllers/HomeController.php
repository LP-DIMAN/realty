<?php 
namespace App\Http\Controllers;
use App\Adverts;
use Auth;

use Illuminate\Http\Request;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */

	public function ajax()
{
    return $this->isXmlHttpRequest();
}
	public function index()
	{
		$data['adverts'] = Adverts::get_adverts();
		
		//dd($data['check_advert'] = Adverts::check_advert(Auth::user()->id,4));
		return view('home',$data);
		abort(404);
	}

	public function remember_adverts(Request $request)
	{
		if ($request->input('remember'))
		{
			$id_advert = $_GET['remember'];
			
			$client = Auth::user()->id;
			Adverts::remember_advert($client,$id_advert);
		
			
		}
				return redirect()->to('/home');


	}

}
