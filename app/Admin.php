<?php namespace App;
	use Illuminate\Database\Eloquent\Model;
	use DB;


	class Admin extends Model
	{
	
	protected static function get_confirmation_realtor(){

		$confirmation_realtor = DB::select('select * from users where confirmation_realtor = ?', [1]);
		$arr = array();
		foreach ($confirmation_realtor as $realtor) {
			$arr[] = $realtor;

		}
		return $arr;
	}

	protected static function get_success_or_cancel_realtor($confirmation_realtor,$id_role,$id){
		

		
			DB::update("update users set confirmation_realtor = $confirmation_realtor, id_role = $id_role where id = $id");
			
					}
	
	protected static function is_access_admin()
	{

		$id = Auth::user()->id;
		$admin = DB::select("select id_role from users where id=$id");
		$arr = array();
		foreach ($admin as $administrator) {
			$arr[] = $administrator;

		}
		return $arr;
	

	}
}
?>