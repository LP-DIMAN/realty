<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClients2advertsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients2adverts', function(Blueprint $table)
		{
			$table->integer('id_client');
			$table->integer('id_adverts');
			$table->text('comment')->nullable();
			$table->integer('cross_advert')->nullable();
			$table->integer('lead')->nullable();
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
