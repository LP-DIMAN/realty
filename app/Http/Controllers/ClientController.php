<?php 
namespace App\Http\Controllers;
use App\Adverts;
use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ClientController extends Controller {



	public function __construct()
	{
		//Проверка на авторизацию
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


	
	//Добавление комментария
	public function edit_advert(Request $request)
	{
		$id_advert = $request->input('id_advert');
		$id_client = Auth::user()->id;
		$comment = $request->input('params');

		Adverts::add_comment($comment,$id_client,$id_advert);
		
	}
		//Удаление объявления
	public function delete_advert(Request $request)
	{
		$id_advert = $request->input('comment');
		$id_client = Auth::user()->id;
		Adverts::delete_advert($id_client,$id_advert);
	
		
	}
	// Перечеркивание объявлений
	public function cross_advert(Request $request)
	{
		$id_advert = $request->input('id_advert');
		$id_client = Auth::user()->id;
		Adverts::cross_advert($id_client,$id_advert);
}
  	//Удаление перечеркнутого объявления
  	
  	public function delete_cross_advert(Request $request)
  	{
		$id_advert = $request->input('id_advert');
		$id_client = Auth::user()->id;
		$result = DB::table('clients2adverts')->where('id_adverts','=',$id_advert)
		->where('id_client','=',$id_client)
		->where('cross_advert','=',1)->update(['cross_advert'=>null]);
		

  	}
	
	// Выделение важного объявления
	public function lead_advert(Request $request)
	{
		$id_advert = $request->input('id_advert');
		$id_client = Auth::user()->id;
		Adverts::lead_advert($id_client,$id_advert);

		
	}
	//Удаление обведенного объявления
	public function delete_lead_advert(Request $request)
	{
		$id_advert = $request->input('id_advert');
		$id_client = Auth::user()->id;
		$result = DB::table('clients2adverts')->where('id_adverts','=',$id_advert)
		->where('id_client','=',$id_client)
		->where('lead','=',1)->update(['lead'=>null]);
		
	}

// Добавление,изменение,удаление встреч
	public function events(Request $request)
	{
		$id_client = Auth::user()->id;
		$date_event = $request->input('start');
		$comment = $request->input('type');
		
		//Добавление встречи
		if ($request -> input('op') == 'add')
		{
			$id_realtor = $request->input('realtor');
			
			Adverts::insert_event($id_client,$id_realtor,$date_event,$comment);
		}
		//Удаление встречи
		elseif($request -> input('op') == 'delete')
		{
			$id = $request->input('id');
			Adverts::delete_event($id);
		}
		//Получаем список встреч
		elseif($request->input('op') == 'source')
		{

		Adverts::select_event($id_client);
		
		}
		//Редактируем встречу
		elseif($request->input('op') == 'edit')
		{
		Adverts::update_event($id_client,$date_event,$comment);

		}

}

}
