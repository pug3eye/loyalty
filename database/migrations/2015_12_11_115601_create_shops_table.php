<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shops', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 100)->unique();
			$table->string('password', 100);
			$table->boolean('is_branch');
			$table->string('owner', 100);
			$table->string('name', 100)->unique();
			$table->string('email', 100)->unique();
			$table->string('image', 200)->nullable();
			$table->string('detail', 200)->nullable();
			$table->string('address', 200)->nullable();
			$table->integer('discount')->nullable();
			$table->integer('start_point')->nullable();
			$table->integer('point_condition')->nullable();
			$table->integer('point_get')->nullable();
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
		Schema::drop('shops');
	}

}
