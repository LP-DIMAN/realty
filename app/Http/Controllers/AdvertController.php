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


        $title = $request->input('title');
        $city = $request->input('city');
        $price = $request->input('price');
        $description = $request->input('description');
        $type_realty = $request->input('type_realty');
        $room = $request->input('room');
        $date = date('Y-m-d H:i:s');
        $img = $request->file('image');
        //dd($img);
        if ($img !== null){
        if ($img->isValid())
        {
            $img->move(public_path().'/images/realty/',$img->getClientOriginalName());

            $image = '/images/realty/'.$img->getClientOriginalName();
        }
    }
    
     
        $realtor =Auth::user()->id;

        if ($type_realty == 'дом' && $room == 0){
          return redirect()->to('/create_advert')->with(['error_advert'=>'Дом или квартира не могут иметь 0 комнат']);
        }
        if ($type_realty == 'квартира' && $room == 0){
          return redirect()->to('/create_advert')->with(['error_advert'=>'Дом или квартира не могут иметь 0 комнат']);
        }
        if ($request->input('new')){
    DB::insert("insert into adverts (id_realtor,type,title,quantity_room,city,description,price,new,image,date) values($realtor,'$type_realty','$title',$room,'$city','$description',$price,1,'$image','$date')");
        
    }
    if($img !==null)
    {
        DB::insert("insert into adverts (id_realtor,type,title,quantity_room,city,description,price,image,date) values($realtor,'$type_realty','$title','$room','$city','$description',$price,'$image','$date')");
        
    }
    else
    {
         DB::insert("insert into adverts (id_realtor,type,title,quantity_room,city,description,price,image,date) values($realtor,'$type_realty','$title','$room','$city','$description',$price,null,'$date')");
    }

        return redirect()->to('/realtor')->with(['advert'=>'Объявление отправлено на проверку']);
    


}
}