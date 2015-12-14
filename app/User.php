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
	protected  function get_clients()
	{
		$result = DB::select("SELECT * FROM users where id_role = 2 and activated = 1");
		return $result;
	}

}
