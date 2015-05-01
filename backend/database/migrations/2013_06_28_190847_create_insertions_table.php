<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsertionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('insertions', function(Blueprint $table)
		{
			$table->increments('id');
            
            $table->integer('city_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->string('address');
            $table->integer('helperRequested');
            $table->text('notice');
            $table->timestamp('howlong');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('insertions');
	}

}