<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Auth;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['surname','name','patronymic','phone', 'email', 'password','activated','id_role','confirmation_realtor'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

//Проверка прав доступа

	public  static function Can($priv, $id_user = null)
	{		
		$a='privs2roles.id_priv';
		$b='privs.id_priv';
		$id_user=Auth::user()->id;


		if ($id_user == null)
			return false;
         $result=DB::select("SELECT * FROM users NATURAL JOIN privs2roles INNER JOIN privs ON $a = $b
          WHERE id = $id_user and description='$priv'");
         foreach ($result as $row) {
         	return $row->description;
         }
       
	}
	//Получаем  список клиентов и их предпочтения
	protected  function get_clients()
	{
		$result = DB::select("SELECT * FROM users as u left JOIN clients2adverts as c on u.id = c.id_client 
			left JOIN adverts as a ON c.id_adverts = a.id_realty
          WHERE c.lead = 1 and u.activated = 1 or u.id_role = 2");
		$arr = [];
		foreach ($result as $client) {
			$arr["$client->surname $client->name $client->patronymic"][] = [
			"id"=>$client->id,
			"id_realtor"=>$client->id_realtor,
			"id_realty"=>$client->id_realty,
			"type"=>$client->type,
			"title" => $client->title,
			"quantity_room" =>$client->quantity_room,
			"city"=>$client->city,
			"description"=>$client->description,
			"new"=>$client->new,
			"price"=>$client->price,
			"status"=>$client->status,
			"image"=>$client->image,
			"date"=>$client->date] ;  
		}
		return $arr;
	}
// Получаем всех подтвержденных риэлторов
	protected  function get_realtors()
	{
		$result = DB::select("SELECT * FROM users where id_role = 3 and activated = 1 and confirmation_realtor = 2 ");
		return $result;
	}


}
