<?php namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Session;

class User extends Eloquent {

	public static function live()
	{	
		$user = null;

		if (Session::has('user_id')) {
			$user = User::find(Session::get('user_id'));
		}
		
		if (!$user) {
			$user = new User();
			$user->save();
			Session::put('user_id', $user->id);
		}

		return $user;
	}

	public function hasCity()
	{
		return $this->city_id != '';
	}
	
}