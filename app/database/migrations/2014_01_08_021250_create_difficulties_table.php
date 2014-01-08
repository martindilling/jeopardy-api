<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDifficultiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('difficulties', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('game_id')->unsigned();
			$table->integer('order');
			$table->string('name')->nullable();
			$table->integer('points');
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
		Schema::drop('difficulties');
	}

}
