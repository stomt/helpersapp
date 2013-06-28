<?php

class Request extends Eloquent {

	protected $softDelete = true;

    protected $guarded = array();

    public static $rules = array();

}