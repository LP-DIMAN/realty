<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Http\Request;



class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
	{ 
	//Проверка прав
		$this->middleware('auth');
		$this->middleware('admin');
	}

	
	public function index()
	{
		// Подтверждение или отклонение риэлтора
		$data['admin'] = Admin::get_confirmation_realtor();
		//Выводим неподтвержденные объявления
		$data['status_advert'] = Admin::where('status','=',0)->get();
		return view('admin',$data);

	}
	//Функция подтверждения или отклонения в риэлторы
	public function get(Request $request)
	{
	
		//Добавление в риэлторы
		
		if ($request->input('success')){
			
			Admin::get_success_or_cancel_realtor(2,3,$_GET['success']);
			return redirect()->to('/admin')->with(['realtor_success'=>'Вы добавили пользователя в риэлторы']);
		}
		// Пользователь так и остается обычным клиентом
			else if ($request->input('cancel'))
			{
			Admin::get_success_or_cancel_realtor(0,2,$_GET['cancel']);
			return redirect()->to('/admin')->with(['realtor_cancel'=>'Вы оставили пользователя обычным клиентом']);
		
	}
	// Успешная проверка объявления
	if ($request->input('success_advert')){
			
			Admin::update_status_advert($_GET['success_advert'],1);
			return redirect()->to('/admin')->with(['realtor_success'=>'Объявление успешно добавлена на сайт']);
		}
		// Объявление проверку не прошло
			else if ($request->input('cancel_advert'))
			{
			Admin::delete_advert($_GET['cancel_advert']);
			return redirect()->to('/admin')->with(['realtor_cancel'=>'Объявление не прошло модерацию']);
		
	}
			

}

}