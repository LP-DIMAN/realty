<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Request;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'surname'=>'required|min:2|max:100',
			'name' => 'required|min:3|max:100',
			'patronymic' => 'required|min:5|max:100',
			'phone' => 'required|min:5|max:13',
			'email' => 'required|email|min:5|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'client'=>'sometimes|accepted',
			'realtor'=>'sometimes|accepted'

		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		
		
		if (Request::input('client')){
		return User::create([
			'surname' => $data['surname'],
			'name' => $data['name'],
			'patronymic' => $data['patronymic'],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'id_role'=>1,
			'password' => bcrypt($data['password']),
		]);
	}
	elseif (Request::input('realtor')){
		return User::create([
			'surname' => $data['surname'],
			'name' => $data['name'],
			'patronymic' => $data['patronymic'],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'id_role'=>1,
			'confirmation_realtor'=>1,
			'password' => bcrypt($data['password']),
		]);
	}
	
	
	}

	

}
