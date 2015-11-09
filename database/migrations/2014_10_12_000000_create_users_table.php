<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('surname',100);
			$table->string('name',100);
			$table->string('patronymic',100);
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->boolean('activated')->default(0); 
			$table->string('phone', 13);
			$table->integer('id_role');
			$table->integer('isAdmin')->default(0);
			$table->integer('confirmation_realtor')->default(0);

			

			$table->rememberToken();
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
		Schema::drop('users');
	}

}
