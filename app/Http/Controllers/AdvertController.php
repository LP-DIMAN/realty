<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\User;
use App\Adverts;
use Auth;
use DB;
use Illuminate\Http\Request;

class AdvertController extends Controller {

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
	
		return view('advert');
	}

	public function create_advert(Request $request)
	{
	$validator = Adverts::validator($request->all());
	if ($validator->fails())
	{
	$this->throwValidationException(
				$request, $validator
			);	
	}

else
{
		$title = $request->input('title');
		$city = $request->input('city');
		$price = $request->input('price');
		$description = $request->input('description');
		$type_realty = $request->input('type_realty');
		$room = $request->input('room');
		$date = date('Y-m-d H:i:s');
		
		$realtor =Auth::user()->id;
	

		if ($request->input('new')){
	DB::insert("insert into adverts (id_realtor,type,title,quantity_room,city,description,price,new,date) values($realtor,'$type_realty','$title',$room,'$city','$description',$price,1,'$date')");
		
	}
	else
	{
		DB::insert("insert into adverts (id_realtor,type,title,quantity_room,city,description,price,date) values($realtor,'$type_realty','$title','$room','$city','$description',$price,'$date')");
		
	}
		return redirect()->to('/realtor')->with(['advert'=>'Объявление отправлено на проверку']);
}

}
}