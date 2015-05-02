<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class City extends Model {

    protected $guarded = array();

    public static $rules = array();

    public function insertions()
    {
    	return $this->hasMany('App\Models\Insertion');
    }

    public function currentInsertions()
    {
    	$user = User::live();
    	return $this->insertions()->with('users')->get()->filter(function($insertion) use ($user)
            {
                $from = strtotime($insertion->howlong);
                $time = time();
                if (($time < $from) || ($time >= $from && $time <= ($from+1440000) && date('Ymd') == date('Ymd', $from))) {
                    if ($insertion->users()->sum('amount') == $insertion->helperRequested) {
                        if ($insertion->user_id == $user->id) {
                            return $insertion;
                        } elseif ($insertion->users()->where('user_id', $user->id)->first()) {
                            return $insertion;
                        }
                    } else {
                        return $insertion;
                    }
                }
            });
    }

}