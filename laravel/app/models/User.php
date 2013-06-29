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

	public static function live()
	{	
		$user = null;

		if (Session::has('user_id')) {
			$user = User::find(Session::get('user_id'));
		}
		
		if (!$user) {
			$user = new User();
			$user->save();
			Session::put('user_id', $user->id);
		}

		return $user;
	}
}