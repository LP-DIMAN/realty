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
		//Проверка прав доступа
		$user = User::Can('CLIENT');

		if($user == null){
			return redirect('/home');
		}
		//ид текущего пользователя
		$client = Auth::user()->id;
//Получаем объявления, которые запомнил клиент
		$data['remember_adverts_client'] = Adverts::get_remember_adverts_client($client);
		//Получаем риэлторов
		$data['realtor'] = User::get_realtors();
		return view('client',$data);
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

// Добавление,изменение,удаление встреч
	public function events(Request $request)
	{
		$id_client = Auth::user()->id;
		$date_event = $request->input('start');
		$comment = $request->input('type');
		
		
		if ($request -> input('op') == 'add')
		{
			$id_realtor = $request->input('realtor');
			
			Adverts::insert_event($id_client,$id_realtor,$date_event,$comment);
		}
	
		elseif($request -> input('op') == 'delete')
		{
			$id = $request->input('id');
			Adverts::delete_event($id);
		}
		elseif($request->input('op') == 'source')
		{
		Adverts::select_event($id_client);
		}

		elseif($request->input('op') == 'edit')
		{
		Adverts::update_event($id_client,$date_event,$comment);

		}

}

}
