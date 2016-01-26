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
Route::any('realtor_events', 'RealtorController@realtor_events');
Route::any('admin', 'AdminController@index');
Route::get('admin_suc','AdminController@get');
Route::get('create_advert','AdvertController@index');
Route::any('adverts','AdvertController@create_advert');
Route::get('true_advert','HomeController@remember_adverts');
Route::get('private_cabinet_client','ClientController@index');
Route::post('add_comment','ClientController@edit_advert');
Route::get('delete_advert','ClientController@delete_advert');
Route::get('cross_advert','ClientController@cross_advert');
Route::get('delete_lead_advert','ClientController@delete_lead_advert');
Route::get('delete_cross_advert','ClientController@delete_cross_advert');
Route::get('lead_advert','ClientController@lead_advert');
Route::any('events','ClientController@events');
Route::any('search_adverts','HomeController@search_adverts');
Route::any('unpublished','HomeController@unpublished');
Route::get('my_adverts','RealtorController@my_adverts');
Route::get('delete_my_advert','RealtorController@delete_my_advert');
Route::get('edit_my_advert','RealtorController@edit_my_advert');
Route::post('result_all_search','HomeController@result_all_search');
Route::post('result_search_clients','RealtorController@search_clients');
Route::post('result_search_adverts_realtor','RealtorController@search_adverts_realtor');
Route::get('autocomplete_adverts','RealtorController@autocomplete_adverts');
Route::get('autocomplete_clients','RealtorController@autocomplete_clients');
Route::get('save_changes','RealtorController@save_changes');
Route::get('desctop_adverts','RealtorController@desctop_adverts');
Route::get('delete_recommended_advert','RealtorController@delete_recommended_advert');






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



