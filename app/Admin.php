<?php namespace App;
	use Illuminate\Database\Eloquent\Model;
	use DB;


	class Admin extends Model
	{
	
	protected $table = 'adverts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id_realtor','id_realty','type','phone', 'title', 'quantity_room','city','description','new','price','status','date'];

	protected static function get_confirmation_realtor(){

		$confirmation_realtor = DB::select('select * from users where confirmation_realtor = ?', [1]);
		$arr = array();
		foreach ($confirmation_realtor as $realtor) {
			$arr[] = $realtor;

		}
		return $arr;
	}
	//Делаем из клиента риэлтора или оставляем все как есть
	protected static function get_success_or_cancel_realtor($confirmation_realtor,$id_role,$id){
	
	DB::update("update users set confirmation_realtor = $confirmation_realtor, id_role = $id_role where id = $id");
			
	}
	
	//Проверяем есть ли у админа права доступа
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
	//Получаем все неподтвержденные объявления
	protected static function get_status_adverts()
	{

		$admin = DB::select("select * from adverts where status = 0");
		$arr = array();
		foreach ($admin as $administrator) {
			$arr[] = $administrator;

		}
		return $arr;
	
	}
	//Обновляем статус объявления
	protected static function update_status_advert($id_realty,$status)
	{

	DB::update("update adverts set status = $status where id_realty = $id_realty");
	}
	//Функция удаления объявления
	protected static function delete_advert($id_realty)
	{

	DB::delete("delete from adverts where id_realty = $id_realty");
	
	}
}
?>