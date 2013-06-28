<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requests', function(Blueprint $table)
		{
			$table->increments('id');
            
            $table->integer('city_id');
            $table->integer('user_id');

            $table->string('address');
            $table->integer('helperRequested');
            // $table->integer('helperConfirmed');
            $table->text('notice');
            $table->timestamp('lifetime');
            $table->timestamp('howlong');

            $table->softDeletes();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('requests');
	}

}