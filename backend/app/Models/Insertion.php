<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Insertion extends Model {

	protected $softDelete = true;

    protected $guarded = array();

    public static $rules = array();

    public function city()
    {
    	return $this->belongsTo('App\Models\City');
    }

    public function users()
    {
    	return $this->belongsToMany('App\Models\User')
    				->withPivot('amount');
    }

    public function user($user_id)
    {
    	return $this->users()->where('user_id', $user_id)->first();
    }

    public function creator()
    {
    	return $this->hasOne('App\Models\User', 'user_id');
    }

}