<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('branches', function(Blueprint $table)
		{

			$table->integer('sub_id')->unsigned()->primary();
			$table->integer('main_id')->unsigned();
			$table->string('name', 100);

			$table->foreign('main_id')
						->references('id')
						->on('shops')
						->onDelete('cascade');

			$table->foreign('sub_id')
						->references('id')
						->on('shops')
						->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('branches');
	}

}
