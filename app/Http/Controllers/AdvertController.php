<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\User;
use App\Adverts;
use Auth;
use DB;
use Illuminate\Http\Request;
use Storage;

class AdvertController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        //Проверка на авторизацию
        
        $this->middleware('auth');
        
        
    }
    public function index()
    {
        //Проверка прав доступа
        $user = User::Can('REALTOR');

        if($user == null){
            return redirect('/home');
        }
    
        return view('advert');
    }

    //Создание объявления
    public function create_advert(Request $request)
    {
    $validator = Adverts::validator($request->all());
    if ($validator->fails())
    {
    $this->throwValidationException(
                $request, $validator
            );  
    }


        $title = $request->input('title');
        $city = $request->input('city');
        $price = $request->input('price');
        $description = $request->input('description');
        $type_realty = $request->input('type_realty');
        $room = $request->input('room');
        $date = date('Y-m-d H:i:s');
        $img = $request->file('image');
        //dd($img);
        //Если изображение существует, проверяем и перемещаем
        if ($img !== null){
        if ($img->isValid())
        {
            $img->move(public_path().'/images/realty/',$img->getClientOriginalName());

            $image = '/images/realty/'.$img->getClientOriginalName();
        }
    }
    
        //Получаем ид текущего пользователя
        $realtor =Auth::user()->id;


// Большой блок проверок при создании объявления
        //Если выбран дом, но количество комнат равно нулю, выдаем ошибку
        if ($type_realty == 'дом' && $room == 0){
          return redirect()->to('/create_advert')->with(['error_advert'=>'Дом или квартира не могут иметь 0 комнат']);
        }
        //Если выбрана квартира, но количество комнат равно нулю, выдаем ошибку
        if ($type_realty == 'квартира' && $room == 0){
          return redirect()->to('/create_advert')->with(['error_advert'=>'Дом или квартира не могут иметь 0 комнат']);
        }
        //Если выбран участок, но количество комнат больше нуля, выдаем ошибку
          if ($type_realty == 'участок' && $room > 0){
          return redirect()->to('/create_advert')->with(['error_advert'=>'Участок не может иметь комнат']);
        }

        if ($request->input('new') && $img !==null){
         DB::table('adverts')->insert(
        ['id_realtor'=>$realtor,'type'=>$type_realty,'title'=>$title,'quantity_room'=>$room,
        'city'=>$city,'description'=>$description,
        'price'=>$price,'new'=>1,'image'=>$image,'date'=>$date]);  
         }

     if ($request->input('new') && $img == null){
        DB::table('adverts')->insert(
        ['id_realtor'=>$realtor,'type'=>$type_realty,'title'=>$title,'quantity_room'=>$room,
        'city'=>$city,'description'=>$description,
        'price'=>$price,'new'=>1,'image'=>null,'date'=>$date]);

    }
    if(!$request->input('new') && $img !==null)
    {
        
        DB::table('adverts')->insert(
        ['id_realtor'=>$realtor,'type'=>$type_realty,'title'=>$title,'quantity_room'=>$room,
        'city'=>$city,'description'=>$description,
        'price'=>$price,'image'=>$image,'date'=>$date]);
    }
    if(!$request->input('new') && $img ==null)
    {

         DB::table('adverts')->insert(
        ['id_realtor'=>$realtor,'type'=>$type_realty,'title'=>$title,'quantity_room'=>$room,
        'city'=>$city,'description'=>$description,
        'price'=>$price,'image'=>null,'date'=>$date]);
    }

        return redirect()->to('/realtor')->with(['advert'=>'Объявление отправлено на проверку']);
    


}
}