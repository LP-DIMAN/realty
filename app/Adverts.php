<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;

class Adverts extends Model {


	public static function validator(array $data)
	{
		return Validator::make($data, [
			'title'=>'required|min:2|max:70',
			'description' => 'required|min:15|max:3000',
			'price' => 'required|min:5|max:16',
			'city' => 'required|min:3|max:75',
			
			
			
		]);
		return $validator;
	}

	public static function get_adverts()
	{
		$adverts = DB::select("select * from adverts as a inner join users as u on a.id_realtor = u.id where status = 1 order by a.date desc");
		return $adverts;
	}
	
	protected static function get_adverts_realtor($id_realtor)
	{
		$adverts = DB::select("SELECT * FROM adverts where id_realtor = $id_realtor and status = 1");
		return $adverts;
	}
		protected static function remember_advert($client,$id_advert)
	{
		 DB::insert("insert into clients2adverts (id_client,id_adverts) values ($client,$id_advert)");
		
	}
	
	protected static function check_advert($client,$id_advert)
	{
		$advert = DB::select("select * from clients2adverts where id_client = $client and id_adverts = '$id_advert'");
		return $advert;
		
		
	}
	protected static function get_remember_adverts_client($client)
	{
		$advert = DB::select("select * from clients2adverts as c  join adverts as a on c.id_adverts = a.id_realty join users as u on a.id_realtor = u.id  where id_client = $client order by a.date desc");
		return $advert;
		
		
	}
	protected static function add_comment($comment,$id_client,$id_advert)
	{
		$add = DB::update("UPDATE clients2adverts set comment='$comment' where id_client='$id_client' and id_adverts='$id_advert'");
		
	}
	protected static function delete_advert($id_client,$id_advert)
	{
		$add = DB::delete("DELETE  from clients2adverts where id_client = '$id_client' and id_adverts = '$id_advert'");
		
	}
	protected static function cross_advert($id_client,$id_advert)
	{
		$add = DB::update("UPDATE clients2adverts set cross_advert = 1 where id_client = '$id_client' and id_adverts = '$id_advert'");
		
		
	}
	protected static function lead_advert($id_client,$id_advert)
	{
		$add = DB::update("UPDATE clients2adverts set lead=1 where id_client='$id_client' and id_adverts='$id_advert'");
		
		
	}


}