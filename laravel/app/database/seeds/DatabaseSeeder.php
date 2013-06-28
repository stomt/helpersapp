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
		$this->call('InsertionsSeeder');
		$this->call('UsersSeeder');
		$this->call('UserInsertionSeeder');
	}

}