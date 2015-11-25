<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;

class Adverts extends Model {


	public static function validator(array $data)
	{
		return Validator::make($data, [
			'title'=>'required|min:2|max:70',
			'description' => 'required|min:15|max:1000',
			'price' => 'required|min:5|max:16',
			'city' => 'required|min:3|max:75',
			
			
			
		]);
		return $validator;
	}

	public static function get_adverts()
	{
		$adverts = DB::select("select * from adverts where status = 1");
		return $adverts;
	}
	
}