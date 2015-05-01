<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('projects', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('projectname');
            $table->string('country');
            $table->string('timezone');

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
        Schema::drop('projects');
	}

}
