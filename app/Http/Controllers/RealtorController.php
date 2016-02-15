<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Adverts;
use Illuminate\Http\Request;
use DB;


class RealtorController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		// Проверка авторизации
		$this->middleware('auth');
		
		
	}
	public function index()
	{
		// Проверка прав доступа
		$user = User::Can('REALTOR');

		if($user == null){
			return redirect('/home');
		}

		
	// Получаем  список клиентов и их предпочтения
		$data['clients'] = User::get_clients();
		//dd($data['clients']);
	// Получаем объявления конкретного риэлтора
		$data['adverts'] = Adverts::get_adverts_realtor(Auth::user()->id);
		

		return view('realtor',$data);
	}
	// Встречи риэлтора
	public function realtor_events(Request $request)
	{
		if ($request->input('op') == 'source')
		Adverts::select_event_for_realtor(Auth::user()->id);
	}
	 // Получение списка объявлений риэлтора
	public function my_adverts()
	{
		$realtor = Auth::user()->id;
		$data['adverts'] = Adverts::where('id_realtor','=',$realtor)->orderBy('date','desc')->get();
		return view('my_adverts',$data);
	}
	// Удаление объявлений риэлтора
	public function delete_my_advert(Request $request)
	{
		$id_realty = $request->input('delete_my_advert');
		Adverts::where('id_realty','=',$id_realty)->delete();
		DB::table('clients2adverts')->where('id_adverts','=',$id_realty);
	}
	// Редактирование объявлений риэлтора
	public function edit_my_advert(Request $request)
	{
		$id_realty = $request->input('edit_my_advert');
		Adverts::where('id_realty','=',$id_realty)->delete();
	}
	//Поиск клиентов по имени и предпочтениям 
	public function search_clients(Request $request)
	{
		$query_clients = $request->input('search_clients');
		 $result = Adverts::result_search_clients($query_clients);
		 
          return $a = json_encode($result,JSON_UNESCAPED_UNICODE);
	}
	//Поиск объявлений риэлтора
	public function search_adverts_realtor(Request $request)
	{
		$search = $request->input('search_adverts_realtor');

		$id_realtor = Auth::user()->id;
		
		$result = Adverts::where('id_realtor','=',$id_realtor)
		->where('status','=',1)
		->where('title','like','%'.$search.'%')
   		->orWhere('price','like','%'.$search.'%')
         ->get();
         
          return $a = json_encode($result,JSON_UNESCAPED_UNICODE);
	}

	//Автодополнение при поиске объявлений
	public function autocomplete_adverts(Request $request)
	{
		$search = $request->input('term');
		$id_realtor = Auth::user()->id;
		$criterions = ['id_realtor'=>$id_realtor,'status'=>1];
		$result = Adverts::where($criterions)
		->where('title','like','%'.$search.'%')
   		->orWhere('price','like','%'.$search.'%')
   		->select('title','price')
         ->get();

       $arr = [];
       foreach ($result as $advert) {
       	$arr = [$advert->title,$advert->price];
       }
      
         return $a = json_encode($arr,JSON_UNESCAPED_UNICODE);
	}
	//Автодополнение при поиске клиентов
	public function autocomplete_clients(Request $request)
	{
		$search = $request->input('term');
		$result = Adverts::result_search_clients($search);
		$arr = [];
		foreach ($result as $clients) {
			$arr = [$clients->surname,$clients->title,$clients->description,$clients->quantity_room,$clients->price];
		}
         return $a = json_encode($arr,JSON_UNESCAPED_UNICODE);
	}
	// Сохранение изменений на рабочем столе
	public function save_changes(Request $request)
	{
		$id_client = $request->input('client');
		
		$id_advert = $request->input('id_advert');
		foreach($id_advert as $advert){

		Adverts::insert_recommended_advert($id_client,$advert);
	}
	
	}

	//Подгрузка сохраненных объявлений
	public function desctop_adverts(Request $request)
	{
		$client = $request->input('client');
		$result = Adverts::view_recommended_adverts($client);
		$json =  json_encode($result,JSON_UNESCAPED_UNICODE);
		return $json;
	}
	//Удаление рекомендованного объявления
	public function delete_recommended_advert(Request $request)
	{
		$id_advert = $request->input('id_advert');
		$id_client = $request->input('id_client');
		DB::table('recommended_adverts')->where('id_advert','=',$id_advert)
		->where('id_client','=',$id_client)->delete();
	}
}
