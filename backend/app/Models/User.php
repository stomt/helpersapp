<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class User extends Model {

    public $fillable = ['city_id'];

	public static function live($city_id = 0 )
	{
        if($city_id == 0) $city_id = Session::get('city_id');
		$user = null;

		if (Session::has('user_id')) {
			$user = User::find(Session::get('user_id'));
		}
		
		if (!$user) {
			$user = new User();
            $user->city_id = $city_id;
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