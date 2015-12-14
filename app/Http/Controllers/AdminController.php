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
		$this->middleware('auth');
		$this->middleware('admin');
	}

	
	public function index()
	{
		$data['admin'] = Admin::get_confirmation_realtor();
		$data['status_advert'] = Admin::get_status_adverts();
		return view('admin',$data);

	}
	public function get(Request $request)
	{
	
		
		
		if ($request->input('success')){
			
			Admin::get_success_or_cancel_realtor(2,3,$_GET['success']);
			return redirect()->to('/admin')->with(['realtor_success'=>'Вы добавили пользователя в риэлторы']);
		}
			else if ($request->input('cancel'))
			{
			Admin::get_success_or_cancel_realtor(0,2,$_GET['cancel']);
			return redirect()->to('/admin')->with(['realtor_cancel'=>'Вы оставили пользователя обычным клиентом']);
		
	}
	if ($request->input('success_advert')){
			
			Admin::update_status_advert($_GET['success_advert'],1);
			return redirect()->to('/admin')->with(['realtor_success'=>'Объявление успешно добавлена на сайт']);
		}
			else if ($request->input('cancel_advert'))
			{
			Admin::delete_advert($_GET['cancel_advert']);
			return redirect()->to('/admin')->with(['realtor_cancel'=>'Объявление не прошло модерацию']);
		
	}
			

}

}