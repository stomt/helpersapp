<?php

class Insertion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'insertions';

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

    public function creator()
    {
    	return $this->hasOne('User', 'user_id');
    }

}