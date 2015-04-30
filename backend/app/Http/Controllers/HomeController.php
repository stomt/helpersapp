<?php namespace App\Http\Controllers;

use Illuminate\Contracts\View;

class HomeController extends BaseController {

	public function index()
	{

		return view('hello');
	}

}