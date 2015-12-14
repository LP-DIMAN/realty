<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');
Route::get('contacts', 'ContactsController@index');
Route::any('confirmation', 'AuthController@postRegister');
Route::get('auth/activate','ConfirmationController@activate');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::any('realtor', 'RealtorController@index');
Route::any('admin', 'AdminController@index');
Route::get('admin_suc','AdminController@get');
Route::get('create_advert','AdvertController@index');
Route::any('adverts','AdvertController@create_advert');
Route::get('true_advert','HomeController@remember_adverts');
Route::get('private_cabinet_client','ClientController@index');
Route::post('add_comment','ClientController@edit_advert');
Route::get('delete_advert','ClientController@delete_advert');
Route::get('cross_advert','ClientController@cross_advert');
Route::get('lead_advert','ClientController@lead_advert');






Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
// Роуты запроса ссылки для сброса пароля
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Роуты сброса пароля
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');



