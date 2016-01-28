<?php 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Code;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CodeController;



class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}
	//Регистрация
		public function postRegister(Request $request)
	{
	
	    $validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}
	   $user=$this->registrar->create($request->all());
		$id=$user->id;
	    //создаем код и записываем код
	    $code = CodeController::generateCode(8);
	    Code::create([
	        'user_id' => $id,
	        'code' => $code,
	    ]);
	    //Генерируем ссылку и отправляем письмо на указанный адрес
	    $url = url('/').'/auth/activate?id='.$id.'&code='.$code;      
	    Mail::send('emails.registration', array('url' => $url), function($message) use ($request)
	    {          
	        $message->to($request->email)->subject('Подтверждение регистрации');
	    });
	     
	    return view('confirmation');
	}
    //Авторизация
	public function postLogin(Request $request)
	{
		
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$email = $request->only('email');
		$user=Code::get_user_activated($email['email']);
	
		

		$credentials = $request->only('email', 'password');
		 if (isset($user->activated) && $user->activated == 0){
			return redirect()->to('/auth/login')->with(['fail' => 
                            'Вы не подтвердили свой email.Перейдите по ссылке,которая пришла вам на почту']);
                                          }

						
                                if ($this->auth->attempt($credentials, $request->has('remember','realtor')))
			{
				$realtor = Code::get_user_realtor($email['email']);
				// Если пользователь - риэлтор
				if ($realtor->id_role == 3 && $realtor->confirmation_realtor == 2)
				{
						
			return redirect()->to('/realtor')->with(['message' => 'Вы вошли как риэлтор']);
				}
				//Если пользователь обычный клиент
		else if ($realtor->id_role == 2 && $realtor->confirmation_realtor == 0)
		{
		return redirect()->to('/home')->with(['client'=>'Вы вошли как клиент']);
		}
				//Если пользователь пока неподтвержденный риэлтор
		else if ($realtor->id_role == 2 && $realtor->confirmation_realtor == 1)
		{
			return redirect()->to('/home')->with(['error_realtor'=>'Вы не являетесь риэлтором. Нужно подтверждение администратора','client'=>'Вы вошли как клиент']);
		}
			//Если пользователь админ
		else if ($realtor->id_role == 1)
		{
			return redirect()->to('/admin')->with(['admin'=>'Вы вошли как админ']);
		}

					}


		return redirect($this->loginPath())

					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
					]);
	}
		
	
}
