<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		$this->call('ProjectsSeeder');
		$this->call('CategoriesSeeder');
		$this->call('CitiesSeeder');
		#$this->call('InsertionsSeeder');
		#$this->call('UsersSeeder');
		#$this->call('UserInsertionSeeder');
	}

}
