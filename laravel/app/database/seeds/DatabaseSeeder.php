<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CitiesSeeder');
		$this->call('RequestsSeeder');
		$this->call('UsersSeeder');
		$this->call('UserRequestSeeder');
	}

}