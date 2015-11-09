<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Code extends Model
{
    protected $table = 'codes';
    protected $fillable = ['user_id', 'code'];

// Получаем статус активации пользователя по email
    public static function get_user_activated($email)
    {
    	$results = DB::select('select activated from users where email = ?', [$email]);
    	$arr[]=array();
    	foreach ($results as $key) {
    		$arr = $key;
    	}
    	return $arr;

    }
    //Получаем ид роли по email
    public static function get_user_realtor($email)
    {
        $results = DB::select('select id_role from users where email = ?', [$email]);
        $arr[]=array();
        foreach ($results as $key) {
            $arr = $key;
        }
        return $arr;
      
   }
    
}