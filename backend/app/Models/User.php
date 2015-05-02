<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class User extends Model {

    public $fillable = ['user_id', 'city_id'];

	public static function live()
	{
        $user = null;

        // Falls user vorhanden
		if (Session::has('user_id')) {
			$user = User::find(Session::get('user_id'));

            // City updaten falls alt
            if(Request::has('city_id')){
                $city_id = Request::input('city_id');
                if($user->city_id != $city_id){
                    $user->city_id = $city_id;
                    $user->save();
                    Session::put('city_id', $city_id);
                }
            }
		}else{
            if(! Request::has('city_id')){
                abort(400, 'Bad Request: city_id missing');
            }
			$user = new User();
            $user->city_id = Request::input('city_id');
			$user->save();

			Session::put([
                'city_id' => $user->city_id,
                'user_id' => $user->id
            ]);
		}

		return $user;
	}

	public function hasCity()
	{
		return $this->city_id != '';
	}
	
}