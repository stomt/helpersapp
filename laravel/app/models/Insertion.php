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

}