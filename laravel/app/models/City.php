<?php

class City extends Eloquent {

    protected $guarded = array();

    public static $rules = array();

    public function insertions()
    {
    	return $this->hasMany('Insertion');
    }

}