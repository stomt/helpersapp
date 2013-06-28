<?php


class User extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	public function hasCity()
	{
		return $this->city_id != '';
	}
}