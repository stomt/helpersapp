<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'city_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public static function live()
    {
        $user = null;

        // Falls user vorhanden
        if (Session::has('user_id')) {
            $user = self::find(Session::get('user_id'));

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
