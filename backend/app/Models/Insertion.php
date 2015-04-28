<?php namespace App\Models;
use Illuminate\Database\Eloquent;

class Insertion extends Eloquent {

	protected $softDelete = true;

    protected $guarded = array();

    public static $rules = array();

    public function city()
    {
    	return $this->belongsTo('City');
    }

    public function users()
    {
    	return $this->belongsToMany('User')
    				->withPivot('amount');
    }

    public function user($user_id)
    {
    	return $this->users()->where('user_id', $user_id)->first();
    }

    public function creator()
    {
    	return $this->hasOne('User', 'user_id');
    }

}