<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;

class Adverts extends Model {
protected $table = 'adverts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id_realtor','id_realty','type','phone', 'title', 'quantity_room','city','description','new','price','status','date'];

	//Валидация
	public static function validator(array $data)
	{
		return Validator::make($data, [
			'title'=>'required|min:2|max:70',
			'description' => 'required|min:15|max:7000',
			'price' => 'required|min:5|max:16',
			'city' => 'required|min:3|max:75',
			'image' => 'image|min:1|max:2048'
			
			
			
		]);
		return $validator;
	}

	public static function get_adverts()
	{
		$adverts = DB::select("SELECT * from adverts as a inner join users as u on a.id_realtor = u.id where status = 1 order by a.date desc");
		return $adverts;
	}
	//Получем объявления риэлтора
	protected static function get_adverts_realtor($id_realtor)
	{
		$adverts = DB::select("SELECT * FROM adverts where id_realtor = $id_realtor and status = 1");
		return $adverts;
	}
		protected static function remember_advert($client,$id_advert)
	{
		 DB::insert("INSERT into clients2adverts (id_client,id_adverts) values ($client,$id_advert)");
		
	}
	//Отметить объявление
	protected static function check_advert($client,$id_advert)
	{
		$advert = DB::select("SELECT * from clients2adverts where id_client = $client and id_adverts = '$id_advert'");
		return $advert;
		
		
	}
	//Запомнить объявления для клиента
	protected static function get_remember_adverts_client($client)
	{
		$advert = DB::select("SELECT * from clients2adverts as c  join adverts as a on c.id_adverts = a.id_realty join users as u on a.id_realtor = u.id  where id_client = $client order by a.date desc");
		return $advert;
		
		
	}
	//Добавления комментария к объявлению
	protected static function add_comment($comment,$id_client,$id_advert)
	{
		$add = DB::update("UPDATE clients2adverts set comment='$comment' where id_client='$id_client' and id_adverts='$id_advert'");
		
	}
	//Удаление объявления из личного кабинета риэлтора
	protected static function delete_advert($id_client,$id_advert)
	{
		$add = DB::delete("DELETE  from clients2adverts where id_client = '$id_client' and id_adverts = '$id_advert'");
		
	}
	//Перечеркнуть объявление
	protected static function cross_advert($id_client,$id_advert)
	{
		$add = DB::update("UPDATE clients2adverts set cross_advert = 1 where id_client = '$id_client' and id_adverts = '$id_advert'");
		
		
	}
	//Обведение объявления
	protected static function lead_advert($id_client,$id_advert)
	{
		$add = DB::update("UPDATE clients2adverts set lead=1 where id_client='$id_client' and id_adverts='$id_advert'");
		
		
	}
	//Добавление встречи
	protected static function insert_event($id_client,$id_realtor,$date_event,$comment)
	{
		$date_event = stripcslashes($date_event);
		$add = DB::insert("INSERT INTO events(id_client,id_realtor,date_event,comment) VALUES ($id_client,'$id_realtor','$date_event','$comment')");
		
		
	}
	//Изменение встречи
	protected static function update_event($id_client,$date_event,$comment)
	{
		$add = DB::insert("UPDATE events set date_event = '$date_event', comment = '$comment' where id_client = $id_client");
		
		
	}
		//Удаление встречи
	protected static function delete_event($id)
	{
		$add = DB::delete("DELETE from events  where id = $id");
		
	}
	
	protected static function select_event($id_client)
	{
		$events = DB::select("SELECT * from events where id_client = $id_client");

		$json = array();
		foreach($events as $event) {
		    $json[] = array('id'=>$event->id,'title'=>$event->comment,'start'=>$event->date_event,'allDay'=>false);
		}
		echo json_encode($json);
		
	}
 //Показ встреч риэлтора
protected static function select_event_for_realtor($id_realtor)
	{
		$events = DB::select("SELECT * from events as e inner join users as u on e.id_client = u.id where id_realtor = $id_realtor");

		$json = array();
		foreach($events as $event) {
		    $json[] = array('id'=>$event->id,'title'=>"$event->comment $event->surname $event->name",'start'=>$event->date_event,'allDay'=>false);
		}
		echo json_encode($json);
		
	}
	// Функция для поиска клиентов по их предпочтениям
protected static function result_search_clients($search)
{
	$result = DB::select("SELECT * FROM users as u left JOIN clients2adverts as c on u.id = c.id_client 
			left JOIN adverts as a ON c.id_adverts = a.id_realty
          WHERE  u.surname like '%$search%' or u.name like '%$search%'
			or u.patronymic like '%$search%' or a.type like '%$search%' or a.title like '%$search%'
			or a.description like '%$search%' or a.quantity_room like '%$search%' or a.city like '%$search%'
			or a.type like '%$search%'

          ");
	return $result;
}


//Вставка рекомендованного объявления
protected static function insert_recommended_advert($id_client,$id_advert)
{
	$result = DB::insert("INSERT INTO recommended_adverts (id_client,id_advert) VALUES ($id_client,$id_advert)");
}

//Показ рекомендованных объявлений

protected static function view_recommended_adverts($id_client)
{
	$result = DB::select("SELECT * from adverts as a inner join recommended_adverts as r on a.id_realty = r.id_advert where id_client = '$id_client'");
	return $result;
}
}