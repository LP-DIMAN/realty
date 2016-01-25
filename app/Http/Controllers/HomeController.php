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

// Настройки ajax
    public function ajax()
{
    return $this->isXmlHttpRequest();
}

    public function index()
    {

        $data['adverts'] = Adverts::get_adverts();
        if (!Auth::guest()){
        $data['recommended_adverts'] = Adverts::view_recommended_adverts(Auth::user()->id);
      }
        //dd($data['check_advert'] = Adverts::check_advert(Auth::user()->id,4));
        return view('home',$data);
        abort(404);
    }

      //Запомннить объявление
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

    // Функция поиска объявлений по параметрам
    public function search_adverts(Request $request)
    {
            $type = $request->input('type');
            $city = $request->input('city');
            $new = $request->input('new');
     
            if ($new)
            {
                $new_house = 1;
            }
          else
          {
            $new_house = 0;
          }
            $count_rooms = $request->input('rooms');
            $min_price = $request->input('min_price');
            $max_price = $request->input('max_price');
            $min_price = (int)$min_price;
            $max_price = (int)$max_price;
            $min_rooms = $request->input('min_rooms');
            $max_rooms = $request->input('max_rooms');

            $results = ['city' => $city,'type' => $type,'status'=>1,'new' => $new_house];
           $found_adverts = Adverts::where($results)->whereRaw("price between '$min_price' and '$max_price'")
           ->whereRaw("quantity_room between '$min_rooms' and '$max_rooms'")->get();
          
           foreach ($found_adverts as $advert):?>

                    <div class="table table-bordered">
                    Объявление добавлено <em> <?=$advert->date;?> </em> <br>
                    <strong><?=$advert->title;?></strong><br>
                    <strong>Тип недвижимости: </strong><?=$advert->type;?><br>
                    <strong>Количество комнат: </strong><?=$advert->quantity_room;?><br>
                    <strong>Город: </strong><?=$advert->city;?><br>
                   <strong> Описание: </strong> <?=$advert->description;?><br> 
                   <? if($advert->new == 1):?>
                   <img src="/images/new.png" id='new' title="новое объявление" alt="новая" width="200" >

                  <?endif;?>
                  
                  <span style="margin-left:721px"><strong>Цена: </strong><?=$advert->price;?> рублей</span>
           <?endforeach;
        //return $found_adverts->toJson();
        
    }
        // Снять с публикации
        public function unpublished(Request $request)
        {
          
              $id_realty = $request->input('unpublished_advert');

             $unpublished_advert = Adverts::where('id_realty','=',$id_realty)->delete();
             
             return $unpublished_advert;

            
            
        }
        //Поиск объявлений
        public function result_all_search(Request $request)
        {
          $search = $request->input('all_search');
          $result = Adverts::where('title','like','%'.$search.'%')
          ->orWhere('description','like','%'.$search.'%')
          ->orWhere('city','like','%'.$search.'%')
          ->orWhere('price','like','%'.$search.'%')
          ->orWhere('type','like','%'.$search.'%')
          ->orWhere('quantity_room','like','%'.$search.'%')
          ->orderBy('date','desc')
          ->get();

          return $a = json_encode($result,JSON_UNESCAPED_UNICODE);
        }
}
