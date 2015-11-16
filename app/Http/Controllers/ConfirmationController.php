<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Code;
use App\User;
use Illuminate\Http\Request;

class ConfirmationController extends Controller {

// Если пользователь перешел по ссылке, актиаируем его
public function activate(Request $request)
		{
		    $res = Code::where('user_id',$request->id)
		        ->where('code',$request->code)
		        ->first();
		     
		    if($res) {
		        //Удаляем использованный код           
		        $res->delete();
		        //активируем аккаунт пользователя           
		        User::find($request->id)
		                ->update([                   
		                    'activated'=>1,
		                ]);
		        //редиректим на страницу авторизации с сообщением об активации
		        return redirect()->to('/auth/login')->with(['message' => 'Вы успешно зарегистрировались.Войдите на сайт']);
		    }
		    return 'куку';
		}
}
