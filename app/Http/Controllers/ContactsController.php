<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class ContactsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	 return view('contacts');
	}

	
}
