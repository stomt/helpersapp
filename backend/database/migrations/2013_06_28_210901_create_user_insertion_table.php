<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInsertionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('insertion_user', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('user_id')->unsigned();
			$table->integer('insertion_id')->unsigned();

			$table->integer('amount');

			$table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('insertion_id')->references('id')->on('insertions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('insertion_user');
	}

}