<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('adverts', function(Blueprint $table)
		{
			$table->integer('id_realtor');
			$table->increments('id_realty');
			$table->string('type',50);
			$table->string('title',128);
			$table->integer('quantity_room');
			$table->string('city', 128);
			$table->text('description');
			$table->integer('new');  
			$table->integer('price');
			$table->integer('status')->default(0);
			$table->datetime('date');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('adverts');
	}

}
